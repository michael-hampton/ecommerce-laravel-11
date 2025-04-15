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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('seller_id')->unsigned();
            $table->bigInteger('order_id')->unsigned();
            $table->enum('payment_method', ['cash', 'card', 'paypal']);
            $table->enum('payment_status', ['pending', 'approved', 'declined', 'refunded'])->default('pending');
            $table->decimal('total', 8, 4)->default(0);
            $table->decimal('shipping', 8, 4)->default(0);
            $table->decimal('discount', 8, 4)->default(0);
            $table->decimal('commission', 8, 4)->default(0);
            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('seller_id')->references('id')->on('users');
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
        Schema::dropIfExists('transactions');
    }
};
