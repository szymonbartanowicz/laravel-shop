<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'qty'];

//    public function order()
//    {
//        return $this->hasOne('App\Models\Order');
//    }

    public function scopeByOrder($query, $order_id)
    {
        return $query->whereOrderId($order_id);
    }

    public function scopeByProduct($query, $product_id)
    {
        return $query->whereProductId($product_id);
    }
}
