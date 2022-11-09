<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('umkms_id');
            $table->foreign('umkms_id')->references('id')->on('umkms')->onDelete('cascade');
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('detail_orders_id');
            $table->foreign('detail_orders_id')->references('id')->on('detail_orders')->onDelete('cascade');
            $table->string("products_name");
            $table->string("category");
            $table->integer("qty");
            $table->string("size");
            $table->string("color");
            $table->string("status");
            $table->string("status_produksi");
            $table->integer("estimasi");
            $table->dateTime("tanggal_mulai")->nullable();
            $table->dateTime("tanggal_selesai")->nullable();
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
        Schema::dropIfExists('productions');
    }
}
