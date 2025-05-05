<?php

declare(strict_types=1);

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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned();
            $table->decimal('commission', 10, 4)->nullable();
            $table->bigInteger('product_id')->unsigned();
            $table->date('approved_date')->nullable();
            $table->decimal('price', 8, 2);
            $table->decimal('discount', 10, 4)->nullable();
            $table->integer('quantity');
            $table->longText('options')->nullable();
            $table->enum('status', ['refund_requested', 'refund_approved', 'ordered', 'delivered', 'cancelled'])->default('ordered');
            $table->bigInteger('seller_id')->unsigned();
            $table->integer('shipping_id')->nullable();
            $table->decimal('shipping_price', 8, 4)->nullable();
            $table->boolean('review_status')->default(false);
            $table->date('delivered_date')->nullable();
            $table->date('cancelled_date')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('courier_id')->nullable();
            $table->foreign('courier_id')->references('id')->on('couriers');
            $table->foreign('seller_id')->references('id')->on('users');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
