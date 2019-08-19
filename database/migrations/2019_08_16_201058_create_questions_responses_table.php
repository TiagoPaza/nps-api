<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions_responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('evaluation');
            $table->string('response_optional');
            $table->bigInteger('question_id')->unsigned();

            $table->timestamps();
        });

        Schema::table('questions_responses', function (Blueprint $table) {
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
        Schema::dropIfExists('questions_responses');
    }
}
