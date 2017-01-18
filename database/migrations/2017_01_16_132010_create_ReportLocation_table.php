<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReportLocationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ReportLocation', function(Blueprint $table)
		{
			$table->increments('ReportLocationID');
			$table->integer('CustomerID');
			$table->string('CustomerNo', 50);
			$table->string('CustomerName');
			$table->integer('DonwloadCount');
			$table->integer('Type');
			$table->date('RequestDate');
			$table->integer('ApplicationID')->unsigned();
			$table->string('ApplicationName');
			$table->integer('ContentID')->unsigned();
			$table->string('ContentName');
			$table->string('Country');
			$table->string('City');
			$table->string('District');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ReportLocation');
	}

}
