<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCountryTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_country_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_code')->unsigned()->index();
            $table->foreign('product_code')
                 ->references('code')->on('products');
            $table->integer('country_code')->unsigned()->index();
            $table->foreign('country_code')
                 ->references('code')->on('countries');
            $table->integer('type_code')->unsigned()->index();
            $table->foreign('type_code')
                 ->references('code')->on('types');
            $table->integer('year');
            $table->integer('planted_area');
            $table->integer('harvested_area');
            $table->integer('production');
            $table->integer('yield');
            $table->integer('value');
            $table->unique(['product_code', 'country_code', 'type_code', 'year']);
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
        Schema::dropIfExists('product_country_types');
    }
}
