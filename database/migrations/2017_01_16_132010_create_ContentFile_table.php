<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContentFileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ContentFile', function(Blueprint $table)
		{
			$table->increments('ContentFileID');
			$table->integer('ContentID')->unsigned()->nullable();
			$table->dateTime('DateAdded')->nullable();
			$table->string('FilePath')->nullable();
			$table->string('FileName')->nullable();
			$table->string('FileName2')->nullable();
			$table->integer('FileSize')->unsigned()->nullable();
			$table->integer('PageCreateProgress')->default(0);
			$table->integer('Transferred')->unsigned()->nullable();
			$table->integer('Interactivity')->unsigned()->nullable();
			$table->integer('HasCreated')->unsigned()->nullable();
			$table->integer('ErrorCount')->unsigned()->nullable();
			$table->string('LastErrorDetail', 1000)->nullable();
			$table->string('InteractiveFilePath')->nullable();
			$table->string('InteractiveFileName')->nullable();
			$table->string('InteractiveFileName2')->nullable();
			$table->integer('InteractiveFileSize')->unsigned()->nullable();
			$table->integer('TotalFileSize')->unsigned()->nullable();
			$table->integer('Included')->default(0);
			$table->integer('Indexed')->default(0);
			$table->integer('StatusID')->unsigned()->nullable();
			$table->integer('CreatorUserID')->unsigned()->nullable();
			$table->dateTime('DateCreated')->nullable();
			$table->integer('ProcessUserID')->unsigned()->nullable();
			$table->dateTime('ProcessDate')->nullable();
			$table->integer('ProcessTypeID')->unsigned()->nullable();
			$table->index(['ContentID','StatusID'], 'ContentID');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ContentFile');
	}

}
