<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('cars', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('brand');
                $table->string('type');
                $table->string('year');
                $table->string('color');
                $table->string('plate');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::drop('cars');
	}

}
