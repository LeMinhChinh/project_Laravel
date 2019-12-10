<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <=10 ; $i++) {
            DB::table('admins')->insert([
                'username' => Str::random(5),
                'password' => bcrypt('10111998'),
                'email' => Str::random(5) . '@gmail.com',
                'phone' => '0327775252' .$i,
                'fullname' => 'Lê Minh Chính',
                'gender' => $i%2 == 0 ? 0 : 1,
                'age' => date('Y-m-d'),
                'address' => null,
                'avatar' => null,
                'role' => 1,
                'status' =>1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' =>null
            ]);
        }
    }
}
