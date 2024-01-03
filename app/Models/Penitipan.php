<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Penitipan extends Model
{
    protected $fillable=['user_id','penitipan_number','sub_total','quantity','delivery_charge','board_charge','status','total_amount','nama_depan','nama_belakang','post_code','address1','phone','email','payment_method','payment_status','shipping_id','board_id','coupon','description','angka','snap_token'];

    public function cart_info(){
        return $this->hasMany('App\Models\Cart','penitipan_id','id');
    }
    public static function getAllPenitipan($id){
        return Penitipan::with('cart_info')->find($id);
    }
    public static function countActivePenitipan(){
        $data=Penitipan::count();
        if($data){
            return $data;
        }
        return 0;
    }
    public function cart(){
        return $this->hasMany(Cart::class);
    }

    public function shipping(){
        return $this->belongsTo(Shipping::class,'shipping_id');
    }
    public function board(){
        return $this->belongsTo(HargaPenitipan::class,'board_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
