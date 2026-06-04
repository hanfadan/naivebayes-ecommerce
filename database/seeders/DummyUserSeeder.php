<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummyUserSeeder extends Seeder
{
    public function run(): void
    {
        $buyFreq = ['Setiap minggu','Setiap bulan','Beberapa bulan','Jarang'];
        $budget  = ['<100k','100-300k','300-600k','>600k'];
        $faktor  = ['Harga','Kualitas','Merek','Trend'];
        $channel = ['Marketplace','Sosmed','Web brand','Offline'];
        $review  = ['Tak pernah','Kadang','Sering','Selalu'];

        $styles = DB::table('styles')->pluck('slug')->toArray() ?: ['kasual','formal','sporty'];
        $colors = DB::table('colors')->pluck('slug')->toArray() ?: ['hitam','putih','biru'];
        $brands = ['Uniqlo','H&M','Zara','Adidas','Nike','Levis'];

        for ($i = 1; $i <= 300; $i++) {
            $uid = DB::table('users')->insertGetId([
                'name'     => "dummy_$i",
                'email'    => "d$i@test",
                'phone'    => '08' . rand(1000000000, 9999999999),
                'birth'    => '2000-01-01',
                'gender'   => $i % 2 ? 'm' : 'f',
                'address'  => '-',
                'password' => '-',
                'role'     => 'user',
                'status'   => 1,
            ]);

            $surveys = [
                ['buy_freq',       $buyFreq],
                ['budget_band',    $budget],
                ['buy_factor',     $faktor],
                ['channel_main',   $channel],
                ['review_consider', $review],
                ['eco_interest',   ['Tidak tertarik','Agak tertarik','Tertarik']],
                ['eco_paymore',    ['Ya','Tidak','Mungkin']],
            ];
            foreach ($surveys as [$qcode, $arr]) {
                DB::table('survey_responses')->insert([
                    'user_id' => $uid,
                    'qcode'   => $qcode,
                    'answer'  => $arr[array_rand($arr)],
                ]);
            }

            $randStyles = (array) array_rand($styles, rand(1, min(3, count($styles))));
            foreach ($randStyles as $k) {
                DB::table('user_styles')->insert(['user_id' => $uid, 'style_slug' => $styles[$k]]);
            }

            $randColors = (array) array_rand($colors, rand(1, min(2, count($colors))));
            foreach ($randColors as $k) {
                DB::table('user_colors')->insert(['user_id' => $uid, 'color_slug' => $colors[$k]]);
            }

            if (rand(0, 1)) {
                DB::table('user_brands')->insert([
                    'user_id'    => $uid,
                    'brand_name' => $brands[array_rand($brands)],
                    'freq'       => ['Sering','Kadang','Jarang'][rand(0, 2)],
                ]);
            }
        }

        $this->command->info('300 dummy users + survey data seeded.');
    }
}
