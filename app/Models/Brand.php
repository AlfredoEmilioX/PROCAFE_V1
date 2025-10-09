<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    // Nombre real de la tabla
    protected $table = 'brands';

    // Clave primaria correcta (todo en minúsculas)
    protected $primaryKey = 'brands_id';

    // Tipo y autoincremento
    public $incrementing = true;
    protected $keyType = 'int';

    // Campos que se pueden llenar
    protected $fillable = ['name', 'slug', 'description'];

    // Relación: una marca tiene muchos productos
    public function products()
    {
        return $this->hasMany(Product::class, 'brands_id', 'brands_id');
    }

    // 👇 Esto corrige el error de rutas (admin.brands.edit)
    public function getRouteKeyName()
    {
        return 'brands_id';
    }
}
