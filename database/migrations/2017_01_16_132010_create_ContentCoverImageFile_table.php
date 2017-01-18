<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContentCoverImageFileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ContentCoverImageFile', function(Blueprint $table)
		{
			$table->increments('ContentCoverImageFileID');
			$table->integer('ContentFileID')->unsigned()->nullable();
			$table->dateTime('DateAdded')->nullable();
			$table->string('FilePath')->nullable();
			$table->string('SourceFileName');
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
		Schema::drop('ContentCoverImageFile');
	}

}
