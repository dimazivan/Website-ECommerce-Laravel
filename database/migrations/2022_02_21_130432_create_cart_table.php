<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('umkms_id');
            $table->bigInteger('users_id');
            $table->bigInteger('promos_id');
            $table->bigInteger("products_id");
            $table->bigInteger("detail_products_id");
            $table->string("products_name");
            $table->string("color");
            $table->string("category");
            $table->string("size");
            $table->integer("qty");
            $table->integer("potongan");
            $table->integer("price");
            $table->integer("subtotal");
            $table->date("date")->nullable();
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
        Schema::dropIfExists('cart');
    }
}
