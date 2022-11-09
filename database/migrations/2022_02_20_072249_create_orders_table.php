<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('promos_id')->nullable();
            $table->foreign('promos_id')->references('id')->on('promos')->onDelete('cascade');
            $table->date("date")->nullable();
            $table->string("first_name")->nullable();
            $table->string("last_name")->nullable();
            $table->string("phone")->nullable();
            $table->string("postal_code")->nullable();
            $table->string("address")->nullable();
            $table->string("districts")->nullable();
            $table->string("ward")->nullable();
            $table->string("city")->nullable();
            $table->string("province")->nullable();
            $table->string("desc")->nullable();
            $table->date("tgl_pengiriman")->nullable();
            $table->integer("potongan");
            $table->integer("total");
            $table->string("status");
            $table->string("pict_payment")->nullable();
            $table->string("status_payment")->nullable();
            $table->text("keterangan")->nullable();
            $table->string("shipping")->nullable();
            $table->string("no_resi")->nullable();
            $table->string("status_shipping")->nullable();
            $table->integer("ongkir")->nullable();
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
}
