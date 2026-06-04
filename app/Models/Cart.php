<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    public $timestamps = false;

    protected $fillable = ['user_id', 'product_id', 'qty', 'price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function findAllByUser(int $userId): array
    {
        return self::select(
            'carts.id', 'carts.qty',
            'products.name', 'products.image', 'products.price', 'products.description',
            'products.id as product',
            'categories.name as category'
        )
            ->leftJoin('products', 'carts.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->where('carts.user_id', $userId)
            ->orderByDesc('carts.id')
            ->get()
            ->toArray();
    }

    public static function totalByUser(int $userId): int
    {
        return (int) self::where('user_id', $userId)->sum('qty');
    }
}
