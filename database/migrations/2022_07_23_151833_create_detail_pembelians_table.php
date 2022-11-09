<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pembelians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pembelians_id');
            $table->foreign('pembelians_id')->references('id')->on('pembelians')->onDelete('cascade');
            $table->unsignedBigInteger('suppliers_id');
            $table->foreign('suppliers_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->string("name_material");
            $table->integer("qty");
            $table->integer("price");
            $table->integer("subtotal");
            $table->date("tgl_pengiriman")->nullable();
            $table->date("tgl_penerimaan")->nullable();
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
        Schema::dropIfExists('detail_pembelians');
    }
}
