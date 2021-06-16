<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');
            $table->float('cost',10,2);
            $table->string('codebar');
            $table->integer('stock');
            $table->float('priceTotal', 10, 2);
            $table->integer('tax');
            $table->boolean('active')->default(1);
            $table->string('description');
            $table->string('reference')->unique();
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('description_kardex');
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
        Schema::dropIfExists('products');
    }
}
