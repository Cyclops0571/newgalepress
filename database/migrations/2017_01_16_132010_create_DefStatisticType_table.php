<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDefStatisticTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('DefStatisticType', function(Blueprint $table)
		{
			$table->increments('DefStatisticTypeID');
			$table->integer('StatisticTypeID')->unsigned();
			$table->string('TypeDefinition');
			$table->integer('Status')->unsigned()->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('DefStatisticType');
	}

}
