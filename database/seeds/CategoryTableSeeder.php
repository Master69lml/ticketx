<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createCategory = new Category();
        $createCategory->name = 'Desarrollo';
        $createCategory->save();

        $createCategory = new Category();
        $createCategory->name = 'Soporte';
        $createCategory->save();

        $createCategory = new Category();
        $createCategory->name = 'Reunión'; 
        $createCategory->save();

        /*$createCategory = new Category();
        $createCategory->name = 'Cableado';
        $createCategory->save();*/

    }
}

