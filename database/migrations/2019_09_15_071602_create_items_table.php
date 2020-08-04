<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('space_id')->unsigned()->references('id')->on('spaces')->onDelete('cascade');
            $table->integer('frequency_id')->unsigned()->nullable()->references('id')->on('frequencies')->onDelete('set null');
            $table->integer('procedure_id')->unsigned()->nullable()->references('id')->on('procedures')->onDelete('set null');
            $table->integer('image_id')->unsigned()->nullable()->references('id')->on('icons')->onDelete('set null');
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
        Schema::dropIfExists('items');
    }
}
