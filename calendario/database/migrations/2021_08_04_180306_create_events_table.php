<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id'); //https://laravel.com/docs/5.8/migrations#generating-migrations
        // creacion de eventos con 'php artisan make:model Event -m' editar la tabla con campos nuevos
            $table->integer('tutor_id');
            $table->integer('alumno_id');

            $table->string('title');
            $table->dateTime('start'); //dateTime obligatorio date solo fallta en full calendar, modificar formato si no se quiere mostar la hora.
            $table->dateTime('end');
            $table->string('color',10);
            $table->mediumText('description')->nullable(); // antes longText

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
