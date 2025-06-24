<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('firstname');
        $table->string('lastname');
        $table->string('email')->unique();
        $table->text('address');
        $table->string('image')->nullable();
        $table->unsignedBigInteger('country_id');
        $table->unsignedBigInteger('state_id');
        $table->unsignedBigInteger('city_id');
        $table->timestamps();

        $table->foreign('country_id')->references('id')->on('countries');
        $table->foreign('state_id')->references('id')->on('states');
        $table->foreign('city_id')->references('id')->on('cities');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
