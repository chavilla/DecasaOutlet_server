<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            //$table->engine = "InnoDB";
            $table->id();
            $table->foreignId('invoice_id')
            ->references('id')
            ->on('invoices')
            ->onDelete('cascade');
            $table->foreignId('product_id')
            ->references('id')
            ->on('products')
            ->onDelete('cascade');
            $table->integer('amount');
            $table->float('prices',5,2);
            $table->float('priceTotal',5,2);
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
        Schema::dropIfExists('details');
    }
}
