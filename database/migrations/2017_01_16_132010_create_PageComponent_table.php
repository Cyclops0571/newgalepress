<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageComponentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('PageComponent', function(Blueprint $table)
		{
			$table->integer('PageComponentID', true);
			$table->integer('ContentFilePageID')->unsigned()->nullable();
			$table->integer('ComponentID')->unsigned()->nullable();
			$table->integer('No')->unsigned()->nullable();
			$table->integer('StatusID')->unsigned()->nullable();
			$table->integer('CreatorUserID')->unsigned()->nullable();
			$table->dateTime('DateCreated')->nullable();
			$table->integer('ProcessUserID')->unsigned()->nullable();
			$table->dateTime('ProcessDate')->nullable();
			$table->integer('ProcessTypeID')->unsigned()->nullable();
			$table->index(['ContentFilePageID','StatusID'], 'ContentFilePageID');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('PageComponent');
	}

}
