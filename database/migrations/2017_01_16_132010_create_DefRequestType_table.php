<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDefRequestTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('DefRequestType', function(Blueprint $table)
		{
			$table->integer('DefRequestTypeID', true);
			$table->integer('RequestTypeID');
			$table->string('RequestDefinition');
			$table->integer('Status')->default(1);
			$table->integer('OldID');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('DefRequestType');
	}

}
