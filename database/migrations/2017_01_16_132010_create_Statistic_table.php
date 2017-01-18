<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStatisticTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Statistic', function(Blueprint $table)
		{
			$table->integer('StatisticID', true);
			$table->integer('ServiceVersion')->default(103);
			$table->string('UID')->nullable();
			$table->integer('Type')->nullable();
			$table->date('RequestDate')->index('RequestDate');
			$table->string('Time')->nullable()->index('IDX_Time');
			$table->string('Lat')->nullable();
			$table->string('Long')->nullable();
			$table->string('Country', 50)->nullable();
			$table->string('City', 50)->nullable();
			$table->string('District', 50)->nullable();
			$table->string('Quarter', 50)->nullable();
			$table->string('Avenue', 50)->nullable();
			$table->string('DeviceID')->nullable();
			$table->integer('CustomerID')->nullable();
			$table->integer('ApplicationID')->nullable();
			$table->integer('ContentID')->nullable();
			$table->integer('Page')->nullable();
			$table->string('Param5')->nullable();
			$table->string('Param6')->nullable();
			$table->string('Param7')->nullable();
			$table->integer('StatusID')->unsigned();
			$table->integer('CreatorUserID')->unsigned();
			$table->dateTime('DateCreated');
			$table->integer('ProcessUserID')->unsigned();
			$table->dateTime('ProcessDate');
			$table->integer('ProcessTypeID')->unsigned();
			$table->index(['CustomerID','ApplicationID','ContentID','DeviceID','Time','Type','Page'], 'IDX_Composite');
			$table->index(['UID','DeviceID'], 'UID');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Statistic');
	}

}
