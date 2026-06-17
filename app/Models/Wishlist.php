<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlists';
    public $timestamps = false;

    protected $fillable = ['user_id', 'product_id'];

    public static function findAllByUser(int $userId): array
    {
        return self::select(
            'wishlists.id',
            'products.id as product',
            'products.name', 'products.image', 'products.price', 'products.description',
            'categories.name as category'
        )
            ->leftJoin('products', 'wishlists.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->where('wishlists.user_id', $userId)
            ->orderByDesc('wishlists.id')
            ->get()
            ->toArray();
    }
}
