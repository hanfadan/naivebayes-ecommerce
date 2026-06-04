<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandProductSeeder extends Seeder
{
    public function run(): void
    {
        $brandCatalog = [
            'Uniqlo' => ['Kaos',    79000,  249000],
            'H&M'    => ['Kaos',    99000,  299000],
            'Zara'   => ['Kemeja', 249000,  699000],
            'Adidas' => ['Jaket',  399000, 1299000],
            'Nike'   => ['Jaket',  399000, 1499000],
            'Levis'  => ['Jaket',  499000, 1399000],
        ];

        foreach (array_unique(array_column($brandCatalog, 0)) as $cat) {
            $slug = strtolower(str_replace(' ', '-', $cat));
            DB::table('categories')->insertOrIgnore(['name' => $cat, 'slug' => $slug, 'parent_id' => 0]);
        }

        foreach ($brandCatalog as $brand => [$cat, $min, $max]) {
            $catId = DB::table('categories')->where('name', $cat)->value('id');

            for ($i = 1; $i <= 5; $i++) {
                $name  = "$brand $cat $i";
                $slug  = strtolower(str_replace([' ', '&'], '-', $name));

                if (DB::table('products')->where('slug', $slug)->exists()) continue;

                DB::table('products')->insert([
                    'category_id' => $catId,
                    'name'        => $name,
                    'slug'        => $slug,
                    'description' => "Produk $cat resmi $brand",
                    'image'       => 'dummy.jpg',
                    'stok'        => rand(20, 120),
                    'price'       => rand($min, $max),
                    'status'      => 1,
                    'created'     => now()->toDateString(),
                    'modified'    => now()->toDateString(),
                ]);
            }
        }

        $this->command->info('30 brand products seeded.');
    }
}
