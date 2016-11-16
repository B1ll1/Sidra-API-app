<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductBigRegionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_big_region_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_code')->unsigned()->index();
            $table->foreign('product_code')
                 ->references('code')->on('products');
            $table->integer('big_region_code')->unsigned()->index();
            $table->foreign('big_region_code')
                 ->references('code')->on('big_regions');
            $table->integer('type_code')->unsigned()->index();
            $table->foreign('type_code')
                 ->references('code')->on('types');
            $table->integer('year');
            $table->integer('planted_area');
            $table->integer('harvested_area');
            $table->integer('production');
            $table->decimal('value',15,2);
            $table->integer('yield');
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
        Schema::dropIfExists('product_big_region_types');
    }
}
