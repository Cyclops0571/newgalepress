<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePackageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Package', function(Blueprint $table)
		{
			$table->integer('PackageID', true);
			$table->string('Name')->nullable();
			$table->boolean('Interactive')->nullable();
			$table->integer('MaxActivePDF')->nullable();
			$table->integer('MonthlyQuote')->nullable();
			$table->integer('Bandwidth')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Package');
	}

}
