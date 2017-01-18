<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCropTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Crop', function(Blueprint $table)
		{
			$table->increments('CropID');
			$table->integer('ObjectType')->unsigned();
			$table->integer('ParentID')->unsigned()->default(0);
			$table->smallInteger('Width')->unsigned();
			$table->smallInteger('Height')->unsigned();
			$table->string('Type', 10);
			$table->boolean('Radius')->default(0);
			$table->string('Description');
			$table->string('Watermark');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Crop');
	}

}
