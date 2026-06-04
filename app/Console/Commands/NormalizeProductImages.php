<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NormalizeProductImages extends Command
{
    protected $signature = 'product:normalize-images';
    protected $description = 'Strip 03_, 04_, 05_ prefix from product image filenames in DB';

    public function handle(): int
    {
        $count = 0;
        DB::table('products')->select('id', 'image')->orderBy('id')->each(function ($row) use (&$count) {
            $clean = preg_replace('#^(0[3-5]_)#', '', $row->image ?? '');
            if ($clean !== $row->image) {
                DB::table('products')->where('id', $row->id)->update(['image' => $clean]);
                $this->line("[{$row->id}] {$row->image} → {$clean}");
                $count++;
            }
        });

        $this->info("Done. Updated: {$count} rows.");
        return self::SUCCESS;
    }
}
