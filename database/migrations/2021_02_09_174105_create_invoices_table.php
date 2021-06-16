<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->foreignId('user_id')
            ->references('user_id')
            ->on('users')
            ->onDelete('cascade');
            $table->foreignId('client_id')
            ->references('client_id')
            ->on('clients')
            ->onDelete('cascade');
            $table->string('ruc_client');
            $table->float('total',5,2);
            $table->enum('payMode', [1,2]);
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
        Schema::dropIfExists('invoices');
    }
}
