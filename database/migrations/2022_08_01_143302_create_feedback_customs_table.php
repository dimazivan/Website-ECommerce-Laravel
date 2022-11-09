<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackCustomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_customs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('umkms_id');
            $table->unsignedBigInteger('customs_id');
            // $table->unsignedBigInteger('products_id');
            $table->foreign('customs_id')->references('id')->on('customs')->onDelete('cascade');
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
        Schema::dropIfExists('feedback_customs');
    }
}
