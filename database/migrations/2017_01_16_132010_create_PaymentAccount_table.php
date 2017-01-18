<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentAccountTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('PaymentAccount', function(Blueprint $table)
		{
			$table->integer('PaymentAccountID', true);
			$table->integer('CustomerID')->unsigned();
			$table->integer('ApplicationID')->unique('ApplicationID');
			$table->string('email');
			$table->string('phone');
			$table->string('title');
			$table->decimal('tckn', 11, 0);
			$table->string('vergi_dairesi');
			$table->decimal('vergi_no', 10, 0);
			$table->integer('CityID');
			$table->integer('kurumsal')->default(0)->comment('Kurumsal: 1 Bireysel: 0');
			$table->text('address', 65535);
			$table->integer('payment_count')->unsigned();
			$table->date('FirstPayment')->nullable();
			$table->date('last_payment_day');
			$table->date('ValidUntil')->nullable();
			$table->integer('WarningMailPhase')->default(0)->comment('1: nazik uyari maili gitti 2: uyari maili gitti 3:tehtit maili gitti');
			$table->string('card_token');
			$table->string('cardToken');
			$table->string('cardUserKey');
			$table->string('bin', 11)->comment('Kartın ilk 6 hanesi');
			$table->string('brand');
			$table->string('cardType');
			$table->string('cardAssociation');
			$table->string('cardFamily');
			$table->string('expiry_month', 2);
			$table->string('expiry_year', 4);
			$table->string('last_4_digits', 4);
			$table->string('holder');
			$table->string('card_verification', 5);
			$table->integer('mail_send')->default(0);
			$table->integer('StatusID')->unsigned();
			$table->dateTime('selected_at');
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
		Schema::drop('PaymentAccount');
	}

}
