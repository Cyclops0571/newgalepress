<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTownsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Towns', function(Blueprint $table)
		{
			$table->increments('TownID');
			$table->boolean('CityID');
			$table->string('TownName', 50);
			$table->string('TownNameUppercase', 50);
			$table->integer('OldID');
			$table->boolean('District')->default(0)->index('bolge');
			$table->boolean('StatusID')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Towns');
	}

}
