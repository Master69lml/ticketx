<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('settings')->insert([
            0 => [
                'id'         => 1,
                'site_name'  => 'TEO Tickets',
                'site_url'   => 'http://example.com',
                'email_to'   => 'admin@example.com',
                'email_from' => 'admin@example.com',
                'created_at' => '2024-06-10 13:42:19',
                'updated_at' => '2024-06-10 13:42:19',
            ],
     ]);
    }
}
