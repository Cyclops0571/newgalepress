<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApplicationTopicTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ApplicationTopic', function(Blueprint $table)
		{
			$table->increments('ApplicationTopicID');
			$table->integer('ApplicationID')->unsigned();
			$table->integer('TopicID')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ApplicationTopic');
	}

}
