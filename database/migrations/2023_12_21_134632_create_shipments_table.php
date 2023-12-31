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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_person_id');
            $table->string('receiver_person_id',255)->nullable(false);
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('service_id');
            $table->float('amount')->nullable(false);
            $table->foreign('sender_person_id')->references('id')->on('persons');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('service_id')->references('id')->on('services');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('shipment_date')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
