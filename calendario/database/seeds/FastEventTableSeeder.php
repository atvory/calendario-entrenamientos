<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class FastEventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fast_events')->insert([  // se puede pasar un unico evento o varios dentro de un array.
            [
                'tutor_id' => '1',
                'act_title' => 'Abdominales',
                'act_description' => 'series de 30',
                'start' => '12:00:00',  //hora final no puede ser menos a inicial
                'end' => '12:30:00',
                'color' => '#3cc926'
            ],
            [
                'tutor_id' => '1',
                'act_title' => 'Flexiones',
                'act_description' => 'series de 50',
                'start' => '12:00:00',  //hora final no puede ser menos a inicial
                'end' => '12:30:00',
                'color' => '#3cc926'
            ],
            [
                'tutor_id' => '1',
                'act_title' => 'Saltos',
                'act_description' => 'series de 30',
                'start' => '12:00:00',  //hora final no puede ser menos a inicial
                'end' => '12:30:00',
                'color' => '#3cc926'
            ],
            [
                'tutor_id' => '1',
                'act_title' => 'Circuito HIT',
                'act_description' => '3 vueltas',
                'start' => '12:00:00',  //hora final no puede ser menos a inicial
                'end' => '12:30:00',
                'color' => '#3cc926'
            ]
        ]);
    }
}
