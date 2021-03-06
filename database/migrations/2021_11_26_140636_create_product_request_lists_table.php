<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRequestListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_request_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_request_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->integer('quantity');
            $table->string('description');
            $table->timestamps();

            // define foreign key
            $table->foreign('product_request_id')->references('id')->on('product_requests')
                  ->constrained()
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('product_id')->references('id')->on('products')
                  ->constrained()
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_request_lists');
    }
}
