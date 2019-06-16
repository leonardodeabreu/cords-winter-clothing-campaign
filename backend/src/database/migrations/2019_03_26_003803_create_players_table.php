<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rfid', 8)->unique();
            $table->string('name', 255);
            $table->string('email', 100)->nullable(true);
            $table->integer('team_id')->nullable(true);
            $table->foreign('team_id')
                  ->references('id')
                  ->on('teams')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
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
        Schema::dropIfExists('players');
    }
}
