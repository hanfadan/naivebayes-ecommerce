<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportSnapProducts extends Command
{
    protected $signature = 'product:import-snap {file : Path to meta_valid.jsonl file}';
    protected $description = 'Import product data from SNAP JSONL file into products table';

    private array $jumlahPerKategori = [
        1  => 2,   // Pakaian Pria
        4  => 32,  // Jaket
        5  => 24,  // Kaos
        6  => 8,   // Sweater
        7  => 5,   // Batik
        8  => 10,  // Kemeja
        11 => 12,  // Dress
        12 => 13,  // Kaos Polo
    ];

    private array $keywordToCategory = [
        'jacket'  => 4,
        'shirt'   => 5,
        'sweater' => 6,
        'batik'   => 7,
        'dress'   => 11,
        'polo'    => 12,
    ];

    public function handle(): int
    {
        $file = $this->argument('file');
        if (!is_readable($file)) {
            $this->error("File not found or not readable: {$file}");
            return self::FAILURE;
        }

        DB::table('products')->truncate();
        $this->info('products table cleared.');

        $today   = now()->toDateString();
        $counter = array_fill_keys(array_keys($this->jumlahPerKategori), 0);

        $handle = fopen($file, 'r');
        while (($line = fgets($handle)) !== false) {
            $item = json_decode(trim($line), true);
            if (!$item) continue;

            $title   = $item['title'] ?? '';
            $catId   = $this->guessCategory($title);
            if (!$catId) continue;

            if ($counter[$catId] >= $this->jumlahPerKategori[$catId]) continue;

            DB::table('products')->insert([
                'category_id' => $catId,
                'name'        => $title,
                'slug'        => $this->slugify($title),
                'image'       => $item['main_image'] ?? '',
                'stok'        => rand(10, 50),
                'price'       => $item['price'] ?? 0,
                'description' => strip_tags($item['description'] ?? ''),
                'status'      => 1,
                'created'     => $today,
                'modified'    => $today,
            ]);

            $counter[$catId]++;
        }
        fclose($handle);

        foreach ($counter as $catId => $count) {
            $this->line("Category {$catId}: {$count} products inserted.");
        }

        $this->info('Import complete.');
        return self::SUCCESS;
    }

    private function guessCategory(string $title): ?int
    {
        $lower = strtolower($title);
        foreach ($this->keywordToCategory as $kw => $catId) {
            if (str_contains($lower, $kw)) return $catId;
        }
        return null;
    }

    private function slugify(string $text): string
    {
        $t = mb_strtolower($text, 'UTF-8');
        $t = preg_replace('/[^a-z0-9]+/u', '-', $t);
        return trim($t, '-');
    }
}
