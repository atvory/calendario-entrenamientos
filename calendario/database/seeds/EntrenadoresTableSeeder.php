<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class EntrenadoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entrenadores')->insert([
            [
                'nombre' => 'manuel',
                'apodo' => 'manu',
                'email' => 'manu@gmail.com',
                'pass' => 'manu1234'
            ]
        ]);
    }
}
