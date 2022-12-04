<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('laravel_session');
            $table->string('player', 100);
            $table->integer("step");
            $table->string('status', 50);
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('game_joker', function (Blueprint $table) {
            $table->uuid('game');
            $table->string('type', 50);
            $table->string('status', 50);
            $table->timestamps();
        });
        DB::statement("ALTER TABLE game_joker ADD CONSTRAINT game_joker_PK PRIMARY KEY (game, type);");

        Schema::create('question', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('session');
            $table->integer("step");
            $table->string('question', 250);
            $table->string('good_answer', 250);
            $table->string('bad_answer1', 250);
            $table->string('bad_answer2', 250);
            $table->string('bad_answer3', 250);
            $table->timestamps();
            $table->primary("id");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game');
        Schema::dropIfExists('game_joker');
        Schema::dropIfExists('question');
    }
};
