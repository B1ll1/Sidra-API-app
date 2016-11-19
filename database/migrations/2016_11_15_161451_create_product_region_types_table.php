<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductRegionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_region_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_code')->unsigned()->index();
            $table->foreign('product_code')
                 ->references('code')->on('products');
            $table->integer('region_code')->unsigned()->index();
            $table->foreign('region_code')
                 ->references('code')->on('regions');
            $table->integer('type_code')->unsigned()->index();
            $table->foreign('type_code')
                 ->references('code')->on('types');
            $table->integer('year');
            $table->integer('planted_area');
            $table->integer('harvested_area');
            $table->integer('production');
            $table->integer('yield');
            $table->integer('value');
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
        Schema::dropIfExists('product_region_types');
    }
}
