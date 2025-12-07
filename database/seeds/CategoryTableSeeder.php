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
        $createCategory->name = 'Técnico';
        $createCategory->save();

        $createCategory = new Category();
        $createCategory->name = 'Error';
        $createCategory->save();

        $createCategory = new Category();
        $createCategory->name = 'Ventas'; 
        $createCategory->save();

        $createCategory = new Category();
        $createCategory->name = 'Cableado';
        $createCategory->save();

    }
}

