<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            // $table->unsignedBigInteger('suppliers_id');
            $table->unsignedBigInteger('umkms_id');
            $table->foreign('umkms_id')->references('id')->on('umkms')->onDelete('cascade');
            // $table->foreign('suppliers_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->date("date")->nullable();
            $table->integer("total");
            // $table->string("pict_payment")->nullable();
            // $table->string("status")->nullable();
            // $table->text("keterangan")->nullable();
            // $table->string("shipping")->nullable();
            // $table->integer("ongkir")->nullable();
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
        Schema::dropIfExists('pembelians');
    }
}
