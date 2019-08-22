<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('questions_current');
            $table->bigInteger('plan_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();

            $table->timestamps();
        });

        Schema::table('plans_activities', function (Blueprint $table) {
            $table->foreign('plan_id')->references('id')
                ->on('plans');

            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans_activities');
    }
}
