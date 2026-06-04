<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReplaceProductsWithReal extends Command
{
    protected $signature = 'product:replace-with-real';
    protected $description = 'Replace dummy products with real data from Shopify demo store';

    private array $mapping = [
        1  => 'mens clothing',
        4  => 'jacket',
        5  => 'shirt',
        6  => 'sweater',
        7  => 'batik',
        8  => 'shirt',
        11 => 'dress',
        12 => 'polo shirt',
    ];

    public function handle(): int
    {
        $jumlahPerKategori = DB::table('products')
            ->select('category_id', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('category_id')
            ->pluck('jumlah', 'category_id')
            ->toArray();

        $json = @file_get_contents('https://shopicruit.myshopify.com/products.json?limit=250');
        if (!$json) {
            $this->error('Gagal mengambil data dari Shopify.');
            return self::FAILURE;
        }

        $allProducts = json_decode($json, true)['products'] ?? [];

        DB::table('products')->truncate();
        $this->info('products table cleared.');

        $today = now()->toDateString();

        foreach ($jumlahPerKategori as $catId => $target) {
            $keyword = $this->mapping[$catId] ?? '';
            if (!$keyword) {
                $this->warn("No keyword mapping for category ID={$catId}");
                continue;
            }

            $matches  = array_filter($allProducts, fn($p) => stripos($p['title'], $keyword) !== false);
            $toInsert = array_slice($matches, 0, $target);

            $inserted = 0;
            foreach ($toInsert as $p) {
                DB::table('products')->insert([
                    'category_id' => $catId,
                    'name'        => $p['title'],
                    'slug'        => $this->slugify($p['title']),
                    'image'       => $p['images'][0]['src'] ?? '',
                    'stok'        => rand(10, 50),
                    'price'       => $p['variants'][0]['price'] ?? 0,
                    'description' => strip_tags($p['body_html'] ?? ''),
                    'status'      => 1,
                    'created'     => $today,
                    'modified'    => $today,
                ]);
                $inserted++;
            }

            $this->info("Category {$catId}: inserted {$inserted}/{$target}");
        }

        $this->info('Done.');
        return self::SUCCESS;
    }

    private function slugify(string $text): string
    {
        $t = mb_strtolower($text, 'UTF-8');
        $t = preg_replace('/[^a-z0-9]+/u', '-', $t);
        return trim($t, '-');
    }
}
