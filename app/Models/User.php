<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Contracts\Auth\MustVerifyEmail; // Descomenta si usarás verificación

class User extends Authenticatable /* implements MustVerifyEmail */
{
    use Notifiable, HasFactory;

    protected $table = 'users';

    // Usamos la PK por defecto "id" (no declares $primaryKey)
    // public $incrementing = true; // por defecto ya es true
    // protected $keyType = 'int';   // por defecto ya es int

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // hash automático al asignar
    ];

    /* ================= Relaciones ================= */

    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'user_id');
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }




    /* ================= Helpers ================= */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
