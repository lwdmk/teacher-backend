<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->smallInteger('type');
            $table->timestamps();
        });

        Schema::create('test_question', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('test_id', false, true);
            $table->text('title');
            $table->smallInteger('type');
            $table->timestamps();

            $table->foreign('test_id')
                ->references('id')->on('test')
                ->onDelete('cascade');
        });

        Schema::create('test_question_answer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id', false, true);
            $table->text('text');
            $table->smallInteger('type')->nullable();
            $table->boolean('is_right')->default(false);
            $table->integer('link_to_right')->nullable();
            $table->timestamps();

            $table->foreign('question_id')
                ->references('id')->on('test_question')
                ->onDelete('cascade');
        });

        Schema::create('test_attempt', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('test_id', false, true);
            $table->integer('user_id', false, true)->nullable();
            $table->jsonb('data');
            $table->smallInteger('score')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('test_id')
                ->references('id')->on('test')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_attempt');
        Schema::dropIfExists('test_question_answer');
        Schema::dropIfExists('test_question');
        Schema::dropIfExists('test');
    }
}
