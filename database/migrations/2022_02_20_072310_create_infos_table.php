<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('umkms_id');
            $table->foreign('umkms_id')->references('id')->on('umkms')->onDelete('cascade');
            $table->string("no_wa")->nullable();
            $table->string("title")->nullable();
            $table->string("alamat")->nullable();
            $table->string("link_tokped")->nullable();
            $table->string("link_shopee")->nullable();
            $table->string("link_email")->nullable();
            $table->string("link_instagram")->nullable();
            $table->text("description_login")->nullable();
            $table->text("description_register")->nullable();
            $table->text("description_umkm")->nullable();
            $table->text("description_product")->nullable();
            $table->text("description_detail")->nullable();
            $table->text("description_lainnya")->nullable();
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
        Schema::dropIfExists('infos');
    }
}
