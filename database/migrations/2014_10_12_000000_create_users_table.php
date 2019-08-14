<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('social_reason');
            $table->string('fantasy_name');
            $table->string('document')->unique();
            $table->string('state_registration')->unique();

            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');

            $table->string('cep');
            $table->string('state');
            $table->string('city');
            $table->char('country', 2);
            $table->string('address');
            $table->integer('number');

            $table->string('complement')->nullable();

            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
