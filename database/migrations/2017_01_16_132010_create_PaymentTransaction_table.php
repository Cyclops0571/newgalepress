<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentTransactionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('PaymentTransaction', function(Blueprint $table)
		{
			$table->increments('PaymentTransactionID');
			$table->integer('PaymentAccountID')->unsigned();
			$table->integer('CustomerID')->unsigned();
			$table->string('transaction_id');
			$table->bigInteger('external_id')->unsigned();
			$table->bigInteger('reference_id');
			$table->string('state', 50);
			$table->decimal('amount', 10);
			$table->string('currency', 50);
			$table->text('request', 65535);
			$table->text('response');
			$table->text('response3d');
			$table->integer('paid')->default(0);
			$table->integer('mail_send')->default(0);
			$table->string('errorCode');
			$table->string('errorMessage');
			$table->string('errorGroup');
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
		Schema::drop('PaymentTransaction');
	}

}
