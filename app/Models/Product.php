<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'categories_id','Brands_id','name','slug','description',
        'price','stock','image','status'
    ];

    public function category()
    {
        // ownerKey = categories.categories_id
        return $this->belongsTo(Category::class, 'categories_id', 'categories_id');
    }
}
