<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'Orders_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id','User_address_id','total_price','status'
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'User_id');
    }

    public function shippingAddress(){
        return $this->belongsTo(ShippingAddress::class, 'User_address_id', 'shipping_addresses_id');
    }

    public function items(){
        return $this->hasMany(OrderItem::class, 'orders_id', 'Orders_id');
    }

    public function payment(){
        return $this->hasOne(Payment::class, 'order_id', 'Orders_id');
    }
}
