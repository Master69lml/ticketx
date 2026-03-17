<?php

use App\Priority;
use Illuminate\Database\Seeder;

class PriorityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createPriority = new Priority();
        $createPriority->name = 'Alta';
        $createPriority->save();

        $createPriority = new Priority();
        $createPriority->name = 'Media';
        $createPriority->save();

        $createPriority = new Priority();
        $createPriority->name = 'Baja';
        $createPriority->save();
    }
}
