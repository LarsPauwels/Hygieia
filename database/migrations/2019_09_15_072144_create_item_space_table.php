<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemSpaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('item_id')->unsigned()->references('id')->on('items')->onDelete('cascade');
            $table->integer('product_id')->unsigned()->references('id')->on('products')->onDelete('cascade');;
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
        Schema::dropIfExists('item_product');
    }
}
