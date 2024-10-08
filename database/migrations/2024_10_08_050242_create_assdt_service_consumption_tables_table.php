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
        Schema::create('assdt_service_consumption_tables', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('scode');
            $table->string('servicename');
            $table->string('servicetype');
            $table->string('transmat');
            $table->string('chargemat');
            $table->dateTime('req_dt');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assdt_service_consumption_tables');
    }
};
