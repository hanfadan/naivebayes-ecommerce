<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $submenu = $request->query('submenu');
        $id      = (int) ($submenu ?: 0);
        $view    = $submenu ? 'admin.submenu' : 'admin.category';

        return view($view, [
            'submenu'    => $submenu,
            'categories' => Category::where('parent_id', $id)->get()->toArray(),
        ]);
    }

    public function delete(Request $request)
    {
        Category::where('id', $request->input('id'))->delete();
        return response()->json(['url' => route('admin.category'), 'error' => false]);
    }

    public function save(Request $request)
    {
        $name = $request->input('name');
        $slug = friendlyUrl($name);

        if (empty($name)) {
            return response()->json(['error' => true, 'message' => 'Nama masih kosong.']);
        }

        if (Category::where('slug', $slug)->exists()) {
            return response()->json(['error' => true, 'message' => 'Nama tidak boleh sama.']);
        }

        $data = ['name' => $name, 'slug' => $slug];

        if (is_numeric($request->input('id'))) {
            Category::where('id', $request->input('id'))->update($data);
            return response()->json(['url' => route('admin.category'), 'error' => false]);
        }

        $url = route('admin.category');
        if ($request->filled('parent')) {
            $url = route('admin.category', ['submenu' => $request->input('parent')]);
            $data['parent_id'] = $request->input('parent');
        }

        Category::create($data);
        return response()->json(['url' => $url, 'error' => false]);
    }
}
