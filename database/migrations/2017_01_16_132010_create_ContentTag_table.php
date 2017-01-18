<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContentTagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ContentTag', function(Blueprint $table)
		{
			$table->integer('ContentID')->unsigned();
			$table->integer('TagID')->unsigned();
			$table->primary(['ContentID','TagID']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ContentTag');
	}

}
