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
            $table->id();
            $table->string('name');
            $table->mediumText('desc');
            $table->string('SKU')->nullable();
            $table->double('price');
            $table->foreignId('category_id')->constrained();
            $table->foreignId('discount_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('tag');
            $table->integer('views')->default(0);
            $table->integer('shared')->default(0);
            $table->string('thumb');
            $table->boolean('status')->default(true);
            $table->mediumText('garelly')->nullable();
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
