<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBannerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Banner', function(Blueprint $table)
		{
			$table->integer('BannerID', true);
			$table->integer('ApplicationID');
			$table->integer('OrderNo');
			$table->string('ImagePublicPath');
			$table->string('ImageLocalPath');
			$table->string('TargetUrl');
			$table->string('TargetContent');
			$table->text('Description', 65535)->nullable();
			$table->integer('Version')->unsigned();
			$table->integer('Status')->default(1);
			$table->integer('StatusID');
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
		Schema::drop('Banner');
	}

}
