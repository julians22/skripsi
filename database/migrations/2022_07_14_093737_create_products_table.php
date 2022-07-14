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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->nullable()->index('products_category_id_foreign');
            $table->string('code', 50)->unique();
            $table->string('name', 225);
            $table->string('slug', 250)->unique();
            $table->string('image', 225)->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10)->nullable();
            $table->integer('quantity')->nullable()->default(0);
            $table->softDeletes();
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
