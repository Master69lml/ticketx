<?php

use Illuminate\Database\Seeder;

class TicketDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear 50 usuarios
        $users = factory('App\User', 50)->create();

        // Crear 200 tickets asociados a los usuarios
        for ($i = 0; $i < 200; $i++) {
            factory('App\Ticket')->create([
                'user_id' => $users->random()->id,
            ]);
        }

        $this->command->info('Se han creado 50 usuarios y 200 tickets exitosamente!');
    }
}
