<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Order', function(Blueprint $table)
		{
			$table->increments('OrderID');
			$table->integer('ApplicationID')->unsigned()->nullable();
			$table->string('OrderNo', 50)->nullable();
			$table->string('Name', 14)->nullable();
			$table->string('Description', 4000)->nullable();
			$table->string('Keywords', 100)->nullable();
			$table->string('Product')->nullable();
			$table->integer('Qty')->nullable();
			$table->string('Website')->nullable();
			$table->string('Email')->nullable();
			$table->string('Facebook')->nullable();
			$table->string('Twitter')->nullable();
			$table->string('Pdf')->nullable();
			$table->string('Image1024x1024')->nullable();
			$table->string('Image640x960')->nullable();
			$table->string('Image640x1136')->nullable();
			$table->string('Image1536x2048')->nullable();
			$table->string('Image2048x1536')->nullable();
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
		Schema::drop('Order');
	}

}
