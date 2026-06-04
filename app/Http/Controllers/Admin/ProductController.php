<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product', [
            'products'   => Product::select('products.*', 'categories.name as category')
                ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                ->get()->toArray(),
            'categories' => Category::all()->toArray(),
        ]);
    }

    public function delete(Request $request)
    {
        $product = Product::find($request->input('id'));
        if ($product) {
            $img  = $product->image;
            $base = public_path('images/');
            foreach (['01_', '02_', '03_', '04_', '05_'] as $prefix) {
                @unlink($base . $prefix . $img);
            }
            $product->delete();
        }

        return response()->json(['url' => route('admin.product'), 'error' => false]);
    }

    public function save(Request $request)
    {
        if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
            return response()->json(['error' => true, 'message' => 'Gambar belum dipilih!']);
        }

        $file = $request->file('image');
        $exts = ['png', 'jpg', 'jpeg', 'gif'];
        $ext  = strtolower($file->getClientOriginalExtension());

        if (!in_array($ext, $exts)) {
            return response()->json(['error' => true, 'message' => 'Berkas tidak valid.']);
        }

        $rand = time();
        $path = public_path('images/');
        if (!file_exists($path)) mkdir($path, 0777, true);

        $filename = $rand . '.' . $ext;
        $file->move($path, $filename);

        foreach (['01_' => [70, 70], '02_' => [100, 100], '03_' => [115, 140], '04_' => [550, 750], '05_' => [569, 528]] as $prefix => [$w, $h]) {
            imageResize($path . $filename, $path . $prefix . $filename, $w, $h);
        }
        @unlink($path . $filename);

        $data = [
            'name'        => $request->input('name'),
            'slug'        => friendlyUrl($request->input('name')),
            'stok'        => $request->input('stok'),
            'price'       => $request->input('price'),
            'status'      => 1,
            'created'     => date('Y-m-d'),
            'modified'    => date('Y-m-d'),
            'category_id' => $request->input('category'),
            'description' => $request->input('description'),
            'image'       => $rand . '.' . $ext,
        ];

        if (is_numeric($request->input('id'))) {
            $old  = $request->input('old');
            foreach (['01_', '02_', '03_', '04_', '05_'] as $prefix) {
                @unlink($path . $prefix . $old);
            }
            Product::where('id', $request->input('id'))->update($data);
        } else {
            Product::create($data);
        }

        return response()->json(['url' => route('admin.product'), 'error' => false]);
    }
}
