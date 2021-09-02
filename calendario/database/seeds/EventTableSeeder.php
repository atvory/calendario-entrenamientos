<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* DB::table('events')->insert([  // se puede pasar un unico evento o varios dentro de un array.
            [
                'title' => 'Abdominales',
                'start' => '2021-08-18 12:30:00',  //hora final no puede ser menos a inicial
                'end' => '2021-08-20 12:30:00',
                'color' => '#61ab46',
                'description' => 'Realizar series de 30 abdominales, descanso de 10 segundos'
            ],
            [
                'title' => 'Dominadas',
                'start' => '2021-08-12 11:00:00',  //hora final no puede ser menos a inicial
                'end' => '2021-08-13 12:30:00',
                'color' => '#96176e',
                'description' => 'Realizar series de 10 dominadas, descanso de 15 segundos'
            ]
        ]); */
    }
}
