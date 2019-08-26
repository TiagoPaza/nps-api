<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions_replies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('evaluation');
            $table->string('response_optional')->nullable();
            $table->bigInteger('question_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('questions_replies', function (Blueprint $table) {
            $table->foreign('question_id')->references('id')
                ->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions_replies');
    }
}
