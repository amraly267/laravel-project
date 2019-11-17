<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('name_en')->nullable(false);//->change();
            $table->string('name_ar')->nullable(false);//->change();
            $table->text('description_en');
            $table->text('description_ar');
            $table->bigInteger('category_id')->unsigned();
            $table->string('image')->default('default.png');
            $table->float('purchasing_price', 10, 2)->nullable(false);//->change();
            $table->float('selling_price', 10, 2)->nullable(false);//->change();
            $table->integer('stock_count')->default(0);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
