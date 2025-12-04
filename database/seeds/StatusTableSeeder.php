<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createStatus = new Status();
        $createStatus->name = 'Abierto';
        $createStatus->save();

        $createStatus = new Status();
        $createStatus->name = 'En Progreso';
        $createStatus->save();

        $createStatus = new Status();
        $createStatus->name = 'Cerrado';
        $createStatus->save();

        $createStatus = new Status();
        $createStatus->name = 'Reabierto';
        $createStatus->save();
    }
}
