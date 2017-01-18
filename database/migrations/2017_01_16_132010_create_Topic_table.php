<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTopicTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Topic', function(Blueprint $table)
		{
			$table->increments('TopicID');
			$table->string('Name')->nullable();
			$table->integer('Order')->unsigned()->nullable();
			$table->integer('StatusID')->unsigned()->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Topic');
	}

}
