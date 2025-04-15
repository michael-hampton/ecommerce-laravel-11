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
        Schema::create('order_logs', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('order_id');
           $table->unsignedBigInteger('order_item_id');
           $table->integer('status_to');
           $table->string('courier_name')->nullable();
           $table->string('tracking_number')->nullable();

           $table->foreign('order_id')->references('id')->on('orders');
           $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
