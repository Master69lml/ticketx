<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AssignCompaniesToUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Asignar empresas a los usuarios existentes
        // Usuario 1 (admin) - una empresa
        DB::table('company_user')->insert([
            'company_id' => 1,
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Usuario 2 (sally) - dos empresas
        DB::table('company_user')->insert([
            [
                'company_id' => 1,
                'user_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'company_id' => 2,
                'user_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Usuario 3 (john) - una empresa
        DB::table('company_user')->insert([
            'company_id' => 2,
            'user_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
