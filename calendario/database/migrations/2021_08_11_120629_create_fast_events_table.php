<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFastEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fast_events', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('tutor_id');
            $table->string('act_title');
            $table->string('act_description');
            $table->time('start')->default('12:00:00');
            $table->time('end')->default('12:30:00');
            $table->string('color', 10)->default('#3cc926');
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
        Schema::dropIfExists('fast_events');
    }
}
