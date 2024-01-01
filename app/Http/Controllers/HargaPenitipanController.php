<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HargaPenitipan;
use App\Models\Coupon;

class HargaPenitipanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hargapenitipan=HargaPenitipan::orderBy('id','DESC')->paginate(10);
        return view('backend.hargapenitipan.index')->with('hargapenitipans',$hargapenitipan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.hargapenitipan.create');
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
            'waktu'=>'required|in:harian,bulanan','tahunan',
            'price'=>'nullable|numeric',
            'status'=>'required|in:active,inactive'
        ]);
        $data=$request->all();
        // return $data;
        $status=hargapenitipan::create($data);
        if($status){
            request()->session()->flash('success','Harga Penitipan successfully created');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('hargapenitipan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hargapenitipan=HargaPenitipan::find($id);
        if(!$hargapenitipan){
            request()->session()->flash('error','HargaPenitipan not found');
        }
        return view('backend.hargapenitipan.edit')->with('hargapenitipan',$hargapenitipan);
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
        $hargapenitipan=HargaPenitipan::find($id);
        $this->validate($request,[
            'waktu'=>'required|in:harian,bulanan','tahunan',
            'price'=>'nullable|numeric',
            'status'=>'required|in:active,inactive'
        ]);
        $data=$request->all();
        // return $data;
        $status=$hargapenitipan->fill($data)->save();
        if($status){
            request()->session()->flash('success','Harga Penitipan successfully updated');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('hargapenitipan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hargapenitipan=HargaPenitipan::find($id);
        if($hargapenitipan){
            $status=$hargapenitipan->delete();
            if($status){
                request()->session()->flash('success','Parga Penitipan successfully deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('hargapenitipan.index');
        }
        else{
            request()->session()->flash('error','Harga Penitipan not found');
            return redirect()->back();
        }
    }
}
