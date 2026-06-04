<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'users';
    public $timestamps = false;

    protected $fillable = [
        'name', 'role', 'email', 'phone', 'birth', 'gender',
        'status', 'address', 'password',
    ];

    protected $hidden = ['password'];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
