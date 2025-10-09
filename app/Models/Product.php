<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name','slug','price','stock','status','categories_id','brands_id','image','description'
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'categories_id', 'categories_id');
    }

    public function brand() {
        return $this->belongsTo(Brand::class, 'brands_id', 'brands_id');
    }
}
