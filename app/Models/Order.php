<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    const STATUS_DRAFT = 'draft';
    const STATUS_NEW = 'new';

    protected $fillable = ['user_id', 'number', 'total', 'status'];

    public function orderItems()
    {
        return $this->hasMany('App\Models\OrderItem');
    }

    public function scopeByUser($query, $user_id)
    {
        return $query->whereUserId($user_id);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->whereStatus($status);
    }
}
