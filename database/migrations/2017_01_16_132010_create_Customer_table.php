<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Customer', function(Blueprint $table)
		{
			$table->increments('CustomerID');
			$table->string('CustomerNo', 50)->nullable();
			$table->string('CustomerName')->nullable();
			$table->string('Address')->nullable();
			$table->string('City', 50)->nullable();
			$table->string('Country', 50)->nullable();
			$table->string('Phone1', 50)->nullable();
			$table->string('Phone2', 50)->nullable();
			$table->string('Email', 50)->nullable();
			$table->string('BillName')->nullable();
			$table->string('BillAddress')->nullable();
			$table->string('BillTaxOffice', 50)->nullable();
			$table->string('BillTaxNumber', 50)->nullable();
			$table->integer('TotalFileSize')->unsigned()->nullable();
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
		Schema::drop('Customer');
	}

}
