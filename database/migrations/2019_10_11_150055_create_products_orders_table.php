<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_orders', function (Blueprint $table) {
//            $table->bigIncrements('id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('order_id');

            $table->integer('quantity')->default(1);

            $table->timestamps();


            $table->foreign('product_id')->references('id')->on('products')
            ->onDelete('cascade');


            $table->foreign('order_id')->references('id')->on('orders')
            ->onDelete('cascade');

            $table->primary(['product_id', 'order_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_orders');
    }
}
