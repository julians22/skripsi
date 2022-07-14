<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProductsCopyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_copy', function (Blueprint $table) {
            $table->foreign(['category_id'], 'products_copy_ibfk_1')->references(['id'])->on('product_categories')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_copy', function (Blueprint $table) {
            $table->dropForeign('products_copy_ibfk_1');
        });
    }
}
