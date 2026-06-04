<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insertOrIgnore([
            'name'     => 'Admin',
            'email'    => 'admin@toko.com',
            'phone'    => '081234567890',
            'birth'    => '1980-01-01',
            'gender'   => 'm',
            'address'  => 'Kantor Pusat',
            'password' => sha1(md5('admin1234')),
            'role'     => 'admin',
            'status'   => 1,
        ]);

        $this->command->info('Admin user created: admin@toko.com / admin1234');
    }
}
