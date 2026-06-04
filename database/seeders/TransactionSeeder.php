<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $users    = DB::table('users')->where('email', 'like', 'd%')->pluck('id')->toArray();
        $products = DB::table('products')->where('stok', '>', 0)->get()->toArray();
        $sold     = [];

        foreach ($users as $uid) {
            $count    = rand(1, min(4, count($products)));
            $randKeys = (array) array_rand($products, $count);

            foreach ($randKeys as $idx) {
                $p   = $products[$idx];
                $qty = rand(1, 3);
                if (($p->stok - ($sold[$p->id] ?? 0)) <= 0) continue;

                $tranId = DB::table('transactions')->insertGetId([
                    'user_id'  => $uid,
                    'invoice'  => 'INV' . uniqid(),
                    'total'    => 0,
                    'created'  => now()->toDateString(),
                    'modified' => now()->toDateString(),
                ]);

                DB::table('transactions_details')->insert([
                    'tran_id'    => $tranId,
                    'product_id' => $p->id,
                    'qty'        => $qty,
                    'price'      => $p->price,
                    'user_id'    => $uid,
                ]);

                $sold[$p->id] = ($sold[$p->id] ?? 0) + $qty;
            }
        }

        foreach ($sold as $pid => $qtySold) {
            DB::table('products')->where('id', $pid)
                ->decrement('stok', min($qtySold, DB::table('products')->where('id', $pid)->value('stok')));
        }

        $this->command->info('Dummy transactions seeded.');
    }
}
