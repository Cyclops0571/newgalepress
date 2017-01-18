<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGoogleMapTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('GoogleMap', function(Blueprint $table)
		{
			$table->integer('GoogleMapID', true);
			$table->integer('ApplicationID');
			$table->text('Name', 65535);
			$table->text('Address', 65535);
			$table->text('Description', 65535);
			$table->text('Latitude', 65535);
			$table->text('Longitude', 65535);
			$table->integer('StatusID');
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
		Schema::drop('GoogleMap');
	}

}
