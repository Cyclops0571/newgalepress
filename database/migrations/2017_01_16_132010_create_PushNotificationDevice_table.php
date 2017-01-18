<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePushNotificationDeviceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('PushNotificationDevice', function(Blueprint $table)
		{
			$table->increments('PushNotificationDeviceID');
			$table->integer('PushNotificationID')->unsigned()->nullable();
			$table->integer('TokenID')->unsigned()->nullable();
			$table->string('UDID')->nullable();
			$table->string('ApplicationToken')->nullable();
			$table->string('DeviceToken')->nullable();
			$table->string('DeviceType', 20)->nullable();
			$table->integer('Sent')->unsigned()->nullable();
			$table->integer('ErrorCount')->unsigned()->nullable();
			$table->string('LastErrorDetail', 1000)->nullable();
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
		Schema::drop('PushNotificationDevice');
	}

}
