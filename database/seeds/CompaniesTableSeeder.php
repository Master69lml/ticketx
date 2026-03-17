<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            [
                'name' => 'Empresa Demo 1',
                'ruc' => '80012345-6',
                'address' => 'Dirección Demo 1',
                'phone' => '021-123456',
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Empresa Demo 2',
                'ruc' => '80054321-9',
                'address' => 'Dirección Demo 2',
                'phone' => '021-654321',
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
