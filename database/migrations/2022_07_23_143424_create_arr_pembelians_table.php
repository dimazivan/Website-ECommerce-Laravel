<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArrPembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arr_pembelians', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('umkms_id');
            $table->bigInteger('users_id');
            $table->bigInteger('suppliers_id');
            $table->string("name_material");
            $table->date("date")->nullable();
            $table->date("tgl_pengiriman")->nullable();
            $table->date("tgl_penerimaan")->nullable();
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
        Schema::dropIfExists('arr_pembelians');
    }
}
