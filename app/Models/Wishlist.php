<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlists';
    protected $primaryKey = 'Wishlists_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false; // tu tabla no define timestamps

    protected $fillable = ['user_id','products_id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'User_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'products_id', 'products_id');
    }
}
