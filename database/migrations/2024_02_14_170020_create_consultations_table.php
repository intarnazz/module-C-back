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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id('consultation_id');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable();
            $table->string('tel')->nullable();
            $table->string('kid')->nullable();
            $table->string('age')->nullable();
            $table->string('code')->nullable();
            $table->string('rejection')->nullable();
            $table->string('result')->nullable();
            $table->string('advice')->nullable();
            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('consultant_id');
            $table->unsignedBigInteger('categori_id');
            $table->unsignedBigInteger('question_id');
            $table->dateTime('dateFrom')->nullable();
            $table->dateTime('dateTo')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('region_id')->references('region_id')->on('regions');
            $table->foreign('organization_id')->references('organization_id')->on('organizations');
            $table->foreign('consultant_id')->references('consultant_id')->on('consultants');
            $table->foreign('categori_id')->references('categori_id')->on('categoris');
            $table->foreign('question_id')->references('question_id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultations');
    }
};
