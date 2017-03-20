<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Content', function(Blueprint $table)
		{
			$table->increments('ContentID');
			$table->integer('ApplicationID')->unsigned()->nullable();
			$table->integer('OrderNo')->unsigned()->default(0);
			$table->string('Name')->nullable();
			$table->string('Detail', 1000)->nullable();
			$table->string('MonthlyName')->nullable();
			$table->date('PublishDate')->nullable();
			$table->smallInteger('IsUnpublishActive')->unsigned()->default(0);
			$table->date('UnpublishDate')->default('2011-11-11');
			$table->integer('IsProtected')->unsigned()->nullable();
			$table->string('Password')->nullable();
			$table->integer('IsBuyable')->unsigned()->nullable();
			$table->decimal('Price', 15)->unsigned()->nullable();
			$table->integer('CurrencyID')->unsigned()->nullable();
			$table->integer('IsMaster')->unsigned()->nullable();
			$table->boolean('Orientation')->default(0);
			$table->string('Identifier')->nullable();
			$table->integer('AutoDownload')->unsigned()->nullable();
			$table->integer('Approval')->unsigned()->nullable();
			$table->integer('Blocked')->unsigned()->nullable();
			$table->integer('Status')->unsigned()->nullable();
			$table->integer('RemoveFromMobile')->default(0);
			$table->integer('Version')->unsigned()->nullable();
			$table->integer('PdfVersion')->unsigned()->nullable()->default(1000);
			$table->integer('CoverImageVersion')->unsigned()->nullable();
			$table->integer('TotalFileSize')->unsigned()->nullable();
			$table->integer('TopicStatus')->unsigned()->default(0);
			$table->integer('StatusID')->unsigned()->nullable();
			$table->integer('CreatorUserID')->unsigned()->nullable();
			$table->dateTime('DateCreated')->nullable();
			$table->integer('ProcessUserID')->unsigned()->nullable();
			$table->dateTime('ProcessDate')->nullable();
			$table->integer('ProcessTypeID')->unsigned()->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Content');
	}

}
