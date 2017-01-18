<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQrcodeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Qrcode', function(Blueprint $table)
		{
			$table->integer('QrcodeID', true);
			$table->integer('QrSiteClientID');
			$table->string('Name');
			$table->string('Email');
			$table->string('TcNo');
			$table->text('Address', 65535);
			$table->string('City');
			$table->string('Phone');
			$table->decimal('Price');
			$table->string('Parameter');
			$table->string('CallbackUrl');
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
		Schema::drop('Qrcode');
	}

}
