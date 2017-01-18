<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContentFilePageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ContentFilePage', function(Blueprint $table)
		{
			$table->increments('ContentFilePageID');
			$table->integer('ContentFileID')->unsigned()->nullable();
			$table->integer('No')->unsigned()->nullable();
			$table->integer('OperationStatus')->nullable()->default(0);
			$table->float('Width', 10, 0)->nullable();
			$table->float('Height', 10, 0)->nullable();
			$table->string('FilePath')->nullable();
			$table->string('FileName')->nullable();
			$table->string('FileName2')->nullable();
			$table->integer('FileSize')->unsigned()->nullable();
			$table->integer('StatusID')->unsigned()->nullable();
			$table->integer('CreatorUserID')->unsigned()->nullable();
			$table->dateTime('DateCreated')->nullable();
			$table->integer('ProcessUserID')->unsigned()->nullable();
			$table->dateTime('ProcessDate')->nullable();
			$table->integer('ProcessTypeID')->unsigned()->nullable();
			$table->index(['ContentFileID','StatusID'], 'ContentFileID');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ContentFilePage');
	}

}
