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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->unsigned();
            $table->decimal('subtotal',10,2);
            $table->decimal('shipping',10,2);
            $table->decimal('discount',10,2);
            $table->decimal('tax',10,2);
            $table->enum('status', ['ordered', 'pending', 'delivered', 'cancelled']);
            $table->boolean('is_shipping_different')->default(true);
            $table->string('note')->nullable();
            $table->date('delivered_date')->nullable();
            $table->date('cancelled_date')->nullable();
            $table->bigInteger('address_id')->unsigned();
            $table->integer('shipping_id')->nullable();
            $table->boolean('review_status')->default(false);
            $table->decimal('total', 10, 4);
            $table->decimal('commission', 10, 4);
            $table->string('tracking_number')->nullable();
            $table->string('courier_name')->nullable();
            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('address_id')->references('id')->on('addresses');
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
        Schema::dropIfExists('orders');
    }
};
