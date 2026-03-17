<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TechnicalStaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('technical_staff')->insert([
            [
                'name' => 'Rodrigo Fernandez',
                'email' => 'rodrigo@ticketx.com',
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Elvio Martínez',
                'email' => 'elvio@ticketx.com',
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
