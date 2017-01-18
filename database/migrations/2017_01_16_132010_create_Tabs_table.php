<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTabsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Tabs', function(Blueprint $table)
		{
			$table->integer('TabID', true);
			$table->integer('ApplicationID');
			$table->string('TabTitle', 45)->default('');
			$table->string('Url');
			$table->string('InhouseUrl');
			$table->string('IconUrl');
			$table->integer('Status')->unsigned();
			$table->integer('StatusID')->unsigned();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Tabs');
	}

}
