<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    public $timestamps = false;

    protected $fillable = ['parent_id', 'name', 'slug'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function scopeRoots($query)
    {
        return $query->where('parent_id', 0);
    }

    public static function dropdownMenuHtml(): string
    {
        $html = '<ul class="dropdown">';
        $roots = self::where('parent_id', 0)->get();

        foreach ($roots as $cat) {
            $html .= '<li><a href="' . route('product', ['category' => $cat->slug]) . '">' . $cat->name . '</a>';
            $children = self::where('parent_id', $cat->id)->get();
            if ($children->isNotEmpty()) {
                $html .= '<ul>';
                foreach ($children as $child) {
                    $html .= '<li><a href="' . route('product', ['category' => $child->slug]) . '">' . $child->name . '</a></li>';
                }
                $html .= '</ul>';
            }
            $html .= '</li>';
        }

        $html .= '</ul>';
        return $html;
    }

    public static function sidebarHtml(): string
    {
        $html  = '<ul class="categor-list">';
        $roots = self::where('parent_id', 0)->get();

        foreach ($roots as $cat) {
            $html .= '<li><a href="' . route('product', ['category' => $cat->slug]) . '">' . $cat->name . '</a>';
            $children = self::where('parent_id', $cat->id)->get();
            if ($children->isNotEmpty()) {
                $html .= '<ul class="categor-list">';
                foreach ($children as $child) {
                    $html .= '<li><a href="' . route('product', ['category' => $child->slug]) . '">' . $child->name . '</a></li>';
                }
                $html .= '</ul>';
            }
            $html .= '</li>';
        }

        $html .= '</ul>';
        return $html;
    }

    public static function selectTreeHtml(): string
    {
        $html  = '';
        $roots = self::where('parent_id', 0)->get();

        foreach ($roots as $cat) {
            $html .= '<option value="' . $cat->slug . '">' . $cat->name . '</option>';
            $children = self::where('parent_id', $cat->id)->get();
            foreach ($children as $child) {
                $html .= '<option value="' . $child->slug . '">&#160;&#160;' . $child->name . '</option>';
            }
        }

        return $html;
    }
}
