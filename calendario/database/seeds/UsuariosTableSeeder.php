<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([ // seed de usuarios de la tabla usuarios de la DB
            [
                'nombre' => 'Victor',
                'apellidos' => 'Naya',
                'email' => 'victor@gmail.com',
            ],
            [
                'nombre' => 'Javier',
                'apellidos' => 'Rey', 
                'email' => 'javier@gmail.com',
            ],
            [
                'nombre' => 'David',
                'apellidos' => 'Naya', 
                'email' => 'david@gmail.com',
            ]
        ]);
    }
}
