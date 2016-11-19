<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('rentals', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('car_id');
                $table->integer('client_id');
                $table->datetime('date_from');
                $table->datetime('date_to');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('rentals');
	}

}
