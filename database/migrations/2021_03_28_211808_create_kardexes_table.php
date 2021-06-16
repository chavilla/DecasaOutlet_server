<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKardexesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kardexes', function (Blueprint $table) {

           //$table->engine='InnoDB';
            $table->id();
            $table->foreignId('product_id')
            ->references('id')
            ->on('products')
            ->onDelete('cascade');
            $table->string('description');
            $table->float('cost_pp',10,2);
            $table->integer('input_amount')->nullable()->default(0);
            $table->float('input_value',10,2)->nullable()->default(0);
            $table->integer('output_amount')->nullable()->default(0);
            $table->float('output_value',10,2)->nullable()->default(0);
            $table->integer('balance_amount');
            $table->float('balance_value',10,2);
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
        Schema::dropIfExists('kardexes');
    }
}
