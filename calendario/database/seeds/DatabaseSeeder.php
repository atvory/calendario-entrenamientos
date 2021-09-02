<?php

use App\Entrenadores;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            /* EventTableSeeder::class,
            FastEventTableSeeder::class,
            UsuariosTableSeeder::class, */ 
            EntrenadoresTableSeeder::class
        ]);
    }
}
