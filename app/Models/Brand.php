<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';
    protected $primaryKey = 'Brands_id'; // tal cual tu DB
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['name','slug','description'];

    public function products(){
        return $this->hasMany(Product::class, 'Brands_id', 'Brands_id');
    }
}
