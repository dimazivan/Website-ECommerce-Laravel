<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('umkms_id');
            $table->unsignedBigInteger('orders_id');
            // $table->unsignedBigInteger('products_id');
            $table->foreign('orders_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('umkms_id')->references('id')->on('umkms')->onDelete('cascade');
            // $table->foreign('products_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer("rating");
            $table->text("desc");
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
        Schema::dropIfExists('feedback_orders');
    }
}
