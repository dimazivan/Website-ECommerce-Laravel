<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('orders_id');
            $table->foreign('orders_id')->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedBigInteger('umkms_id');
            $table->foreign('umkms_id')->references('id')->on('umkms')->onDelete('cascade');
            $table->unsignedBigInteger("products_id");
            $table->foreign('products_id')->references('id')->on('products')->onDelete('cascade');
            $table->bigInteger('detail_products_id');
            $table->string("products_name");
            $table->string("category");
            $table->string("size");
            $table->string("color");
            $table->integer("qty");
            $table->integer("price");
            $table->integer("subtotal");
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
        Schema::dropIfExists('detail_orders');
    }
}
