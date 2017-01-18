<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupCodeLanguageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('GroupCodeLanguage', function(Blueprint $table)
		{
			$table->integer('GroupCodeID');
			$table->integer('LanguageID');
			$table->string('DisplayName')->nullable();
			$table->primary(['GroupCodeID','LanguageID']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('GroupCodeLanguage');
	}

}
