<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_table_2', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['purchase', 'sale'])->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->string('code');
            $table->enum('status', ['pending', 'paid', 'canceled'])->default('pending')->nullable();
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
        Schema::dropIfExists('transaction_table_2');
    }
}
