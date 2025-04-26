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
        Schema::table('delivery_methods', function (Blueprint $table) {
            $table->unsignedBigInteger('courier_id')->nullable();
            $table->foreign('courier_id')->references('id')->on('couriers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_mwthods', function (Blueprint $table) {
            //
        });
    }
};
