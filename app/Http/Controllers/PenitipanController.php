<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Penitipan;
use App\Models\Shipping;
use App\Models\HargaPenitipan;
use App\User;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;

class PenitipanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penitipans=Penitipan::orderBy('id','DESC')->paginate(10);
        return view('backend.penitipan.index')->with('penitipans',$penitipans);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'nama_depan'=>'string|required',
            'nama_belakang'=>'string|required',
            'address1'=>'string|required',
            'description'=>'string|required',
            'angka'=>'numeric|required',           
            'coupon'=>'nullable|numeric',
            'phone'=>'numeric|required',
            'post_code'=>'string|nullable',
            'email'=>'string|required'
        ]);
        // return $request->all();

        if(empty(Cart::where('user_id',auth()->user()->id)->where('penitipan_id',null)->first())){
            request()->session()->flash('error','Cart is Empty !');
            return back();
        }
        // $cart=Cart::get();
        // // return $cart;
        // $cart_index='ORD-'.strtoupper(uniqid());
        // $sub_total=0;
        // foreach($cart as $cart_item){
        //     $sub_total+=$cart_item['amount'];
        //     $data=array(
        //         'cart_id'=>$cart_index,
        //         'user_id'=>$request->user()->id,
        //         'product_id'=>$cart_item['id'],
        //         'quantity'=>$cart_item['quantity'],
        //         'amount'=>$cart_item['amount'],
        //         'status'=>'new',
        //         'price'=>$cart_item['price'],
        //     );

        //     $cart=new Cart();
        //     $cart->fill($data);
        //     $cart->save();
        // }

        // $total_prod=0;
        // if(session('cart')){
        //         foreach(session('cart') as $cart_items){
        //             $total_prod+=$cart_items['quantity'];
        //         }
        // }

        $penitipan=new Penitipan();
        $penitipan_data=$request->all();
        $penitipan_data['penitipan_number']='BRD-'.strtoupper(Str::random(10));
        $penitipan_data['user_id']=$request->user()->id;
        $penitipan_data['shipping_id']=$request->shipping;
        $penitipan_data['board_id']=$request->board;
        $shipping=Shipping::where('id',$penitipan_data['shipping_id'])->pluck('price');
        $board=HargaPenitipan::where('id',$penitipan_data['board_id'])->pluck('price');
        // return session('coupon')['value'];
        $penitipan_data['sub_total']=Helper::totalCartPriceBoard();
        $penitipan_data['quantity']=Helper::cartCount();
        
        if(session('coupon')){
            $penitipan_data['coupon']=session('coupon')['value'];
        }
        if($request->shipping){
            if(session('coupon')){
                $penitipan_data['total_amount']=Helper::totalCartPriceBoard()+$shipping[0]-session('coupon')['value'];
            }
            else{
                $penitipan_data['total_amount']=Helper::totalCartPriceBoard()+$shipping[0];
            }
        }
       
        else{
            if(session('coupon')){
                $penitipan_data['total_amount']=Helper::totalCartPriceBoard()-session('coupon')['value'];
            }
            else{
                $penitipan_data['total_amount']=Helper::totalCartPriceBoard();
            }
        }
       
        // return $penitipan_data['total_amount'];
        $penitipan_data['status']="new";
        if(request('payment_method')=='bayar'){
            $penitipan_data['payment_method']='bayar';
            $penitipan_data['payment_status']='paid';
        }
        else{
            $penitipan_data['payment_method']='cod';
            $penitipan_data['payment_status']='Unpaid';
        }
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' =>$penitipan_data['penitipan_number'] ,
                'gross_amount' => $penitipan_data['total_amount'],
            ),
            'customer_details' => array(
                'first_name' => $penitipan_data['nama_depan'] ,
                'last_name' => $penitipan_data['nama_belakang'],
                'email' => $penitipan_data['email'],
                'phone' => $penitipan_data['phone'],
            )
        );
        
        $snapToken = \Midtrans\Snap::getSnapToken($params); 

        $penitipan_data['snap_token']=$snapToken;

        $penitipan->fill($penitipan_data);
        $status=$penitipan->save();
        if($penitipan)
        // dd($penitipan->id);
        $users=User::where('role','admin')->first();
        $details=[
            'title'=>'New penitipan created',
            'actionURL'=>route('penitipan.show',$penitipan->id),
            'fas'=>'fa-file-alt'
        ];
        Notification::send($users, new StatusNotification($details));
        if(request('payment_method')=='bayar'){
            return redirect()->route('penitipan.transaksi', ['id' => $penitipan->id])->with(['id' => $penitipan->id]);
        }
        else{
            session()->forget('cart');
            session()->forget('coupon');
        }
        Cart::where('user_id', auth()->user()->id)->where('penitipan_id', null)->update(['penitipan_id' => $penitipan->id]);

        // dd($users);        
        request()->session()->flash('success','Your product successfully placed in penitipan');
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penitipan=Penitipan::find($id);
        // return $penitipan;
        return view('backend.penitipan.show')->with('penitipan',$penitipan);
    }
    public function pay($id)
    {
        $penitipan=Penitipan::find($id);
        return view('frontend.pages.transaksii')->with('penitipan',$penitipan);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $penitipan=penitipan::find($id);
        return view('backend.penitipan.edit')->with('penitipan',$penitipan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $penitipan=Penitipan::find($id);
        $this->validate($request,[
            'status'=>'required|in:new,process,delivered,cancel'
        ]);
        $data=$request->all();
        // return $request->status;
        if($request->status=='delivered'){
            foreach($penitipan->cart as $cart){
                $product=$cart->product;
                // return $product;
                $product->stock -=$cart->quantity;
                $product->save();
            }
        }
        $status=$penitipan->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated penitipan');
        }
        else{
            request()->session()->flash('error','Error while updating penitipan');
        }
        return redirect()->route('penitipan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penitipan=Penitipan::find($id);
        if($penitipan){
            $status=$penitipan->delete();
            if($status){
                request()->session()->flash('success','penitipan Successfully deleted');
            }
            else{
                request()->session()->flash('error','penitipan can not deleted');
            }
            return redirect()->route('penitipan.index');
        }
        else{
            request()->session()->flash('error','penitipan can not found');
            return redirect()->back();
        }
    }

    public function orderTrack(){
        return view('frontend.pages.order-track');
    }

    public function productTrackOrder(Request $request){
        // return $request->all();
        $penitipan=Penitipan::where('user_id',auth()->user()->id)->where('penitipan_number',$request->penitipan_number)->first();
        if($penitipan){
            if($penitipan->status=="new"){
            request()->session()->flash('success','Your penitipan has been placed. please wait.');
            return redirect()->route('home');

            }
            elseif($penitipan->status=="process"){
                request()->session()->flash('success','Your penitipan is under processing please wait.');
                return redirect()->route('home');
    
            }
            elseif($penitipan->status=="delivered"){
                request()->session()->flash('success','Your penitipan is successfully delivered.');
                return redirect()->route('home');
    
            }
            else{
                request()->session()->flash('error','Your penitipan canceled. please try again');
                return redirect()->route('home');
    
            }
        }
        else{
            request()->session()->flash('error','Invalid penitipan numer please try again');
            return back();
        }
    }

    // PDF generate
    public function pdf(Request $request){
        $penitipan=Penitipan::getAllPenitipan($request->id);
        // return $penitipan;
        $file_name=$penitipan->penitipan_number.'-'.$penitipan->nama_depan.'.pdf';
        // return $file_name;
        $pdf=PDF::loadview('backend.penitipan.pdf',compact('penitipan'));
        return $pdf->download($file_name);
    }
    // Income chart
    public function incomeChart(Request $request){
        $year=\Carbon\Carbon::now()->year;
        // dd($year);
        $items=Penitipan::with(['cart_info'])->whereYear('created_at',$year)->where('status','delivered')->get()
            ->groupBy(function($d){
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
            // dd($items);
        $result=[];
        foreach($items as $month=>$item_collections){
            foreach($item_collections as $item){
                $amount=$item->cart_info->sum('amount');
                // dd($amount);
                $m=intval($month);
                // return $m;
                isset($result[$m]) ? $result[$m] += $amount :$result[$m]=$amount;
            }
        }
        $data=[];
        for($i=1; $i <=12; $i++){
            $monthName=date('F', mktime(0,0,0,$i,1));
            $data[$monthName] = (!empty($result[$i]))? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
}
