<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRequestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Request', function(Blueprint $table)
		{
			$table->increments('RequestID');
			$table->integer('RequestTypeID')->unsigned()->nullable();
			$table->integer('CustomerID')->unsigned()->nullable();
			$table->integer('ApplicationID')->unsigned()->nullable();
			$table->integer('ContentID')->unsigned()->nullable()->index('ContentID');
			$table->integer('ContentFileID')->unsigned()->nullable();
			$table->integer('ContentCoverImageFileID')->unsigned()->nullable();
			$table->dateTime('RequestDate')->nullable();
			$table->string('IP', 50)->nullable();
			$table->string('DeviceType')->nullable();
			$table->integer('DeviceOS')->index('DeviceOS')->comment('1 ios, 2 android, 3 windows mobile, 4 blackbarry, 5 linux');
			$table->integer('FileSize')->unsigned()->nullable();
			$table->integer('DataTransferred')->unsigned()->nullable();
			$table->integer('Percentage')->unsigned()->nullable();
			$table->integer('StatusID')->unsigned()->nullable();
			$table->integer('CreatorUserID')->unsigned()->nullable();
			$table->dateTime('DateCreated')->nullable();
			$table->integer('ProcessUserID')->unsigned()->nullable();
			$table->dateTime('ProcessDate')->nullable();
			$table->integer('ProcessTypeID')->unsigned()->nullable();
			$table->index(['ContentID','RequestTypeID','Percentage','RequestDate'], 'RequestTypeID');
			$table->index(['ContentID','RequestTypeID'], 'RequestTypeID_2');
			$table->index(['RequestTypeID','RequestDate','DeviceOS','Percentage'], 'RequestTypeID_3');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Request');
	}

}
