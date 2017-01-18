<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Log', function(Blueprint $table)
		{
			$table->increments('LogID');
			$table->integer('CustomerID')->unsigned()->index('IDX_CustomerID');
			$table->integer('ApplicationID')->unsigned()->index('IDX_ApplicationID');
			$table->integer('ContentID')->unsigned()->index('IDX_ContentID');
			$table->integer('ContentFileID')->unsigned();
			$table->integer('Size')->unsigned();
			$table->string('Url', 1000);
			$table->dateTime('Date');
			$table->string('IP', 50);
			$table->string('UserAgent');
			$table->index(['ContentID','Date'], 'IDX_Composite1');
			$table->index(['ContentID','Url','Date'], 'IDX_Composite2');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Log');
	}

}
