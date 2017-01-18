<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientReceiptTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ClientReceipt', function(Blueprint $table)
		{
			$table->integer('ClientReceiptID', true);
			$table->integer('ClientID');
			$table->string('SubscriptionID');
			$table->string('Platform');
			$table->string('PackageName');
			$table->string('SubscriptionType');
			$table->dateTime('SubscriptionStartDate');
			$table->dateTime('SubscriptionEndDate');
			$table->text('Receipt');
			$table->text('MarketResponse');
			$table->integer('StatusID')->default(1);
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
		Schema::drop('ClientReceipt');
	}

}
