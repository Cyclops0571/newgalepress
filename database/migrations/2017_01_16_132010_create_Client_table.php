<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Client', function(Blueprint $table)
		{
			$table->increments('ClientID');
			$table->integer('ApplicationID')->unsigned();
			$table->string('Username');
			$table->string('Password');
			$table->string('Email');
			$table->string('Token')->unique('Token');
			$table->string('DeviceToken');
			$table->string('Name');
			$table->string('Surname');
			$table->dateTime('PaidUntil')->nullable();
			$table->integer('SubscriptionChecked');
			$table->text('ContentIDSet', 65535);
			$table->dateTime('LastLoginDate');
			$table->integer('InvalidPasswordAttempts');
			$table->string('PWRecoveryCode', 20)->nullable();
			$table->dateTime('PWRecoveryDate')->nullable();
			$table->integer('Version')->unsigned()->default(0);
			$table->integer('StatusID')->unsigned();
			$table->integer('CreatorUserID')->unsigned();
			$table->timestamps();
			$table->unique(['ApplicationID','Username'], 'ApplicationID');
			$table->unique(['ApplicationID','Email'], 'ApplicationID_2');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Client');
	}

}
