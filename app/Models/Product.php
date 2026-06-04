<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $table = 'products';
    public $timestamps = false;

    protected $fillable = [
        'name', 'slug', 'stok', 'price', 'status',
        'created', 'modified', 'category_id', 'description', 'image', 'brand',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function findHome(?string $search, ?string $category)
    {
        $query = self::select('products.*', 'categories.name as category')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id');

        if (!empty($search)) {
            $query->where('products.name', 'LIKE', '%' . $search . '%');
        }

        if (!empty($category)) {
            $query->where('categories.slug', $category);
        }

        return $query->get()->toArray();
    }

    public static function findLast(int $count = 8): array
    {
        return self::select('products.*', 'categories.name as category')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->orderByDesc('products.id')
            ->limit($count)
            ->get()
            ->toArray();
    }

    public static function bestSellers(?string $slug = null, int $limit = 5): array
    {
        $query = DB::table('transactions_details as td')
            ->select(DB::raw('SUM(td.qty) as sold'), 'p.*', 'c.name as category')
            ->join('products as p', 'p.id', '=', 'td.product_id')
            ->join('categories as c', 'c.id', '=', 'p.category_id')
            ->groupBy('td.product_id')
            ->orderByDesc('sold')
            ->limit($limit);

        if ($slug) {
            $query->where('c.slug', $slug);
        }

        return $query->get()->toArray();
    }
}
