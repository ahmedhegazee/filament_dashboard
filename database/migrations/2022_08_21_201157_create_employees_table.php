<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address');
            $table->char('zip_code');
            $table->date('birth_date');
            $table->date('hired_date');
            $table->foreignId('department_id')->references('id')->on('departments')->onDelete('cascade')->constrained();
            $table->foreignId('state_id')->references('id')->on('states')->onDelete('cascade')->constrained();
            $table->foreignId('city_id')->references('id')->on('cities')->onDelete('cascade')->constrained();
            $table->foreignId('country_id')->references('id')->on('countries')->onDelete('cascade')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};