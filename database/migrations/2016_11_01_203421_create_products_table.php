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
            $table->increments('id');
            $table->string('title');
            $table->longText('description');
            $table->decimal('price', 7, 2)->unsigned();
            $table->smallInteger('discount')->unsigned()->default(0)->comment('Discount percentage');
            $table->integer('bundle')->nullable()->unsigned()
                ->comment('Create a bundle by putting here a bundle ID. The discount for a bundle is fixed (10%)');
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
