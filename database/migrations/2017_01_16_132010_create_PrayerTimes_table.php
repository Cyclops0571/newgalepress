<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePrayerTimesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('PrayerTimes', function(Blueprint $table)
		{
			$table->increments('PrayerTimeID');
			$table->integer('gun')->unsigned()->index('hicri_yil_2');
			$table->integer('CityID')->unsigned();
			$table->integer('TownID')->unsigned();
			$table->string('PlaceName', 20)->index('yer_adi');
			$table->string('EngPlaceName');
			$table->date('miladi_tarih');
			$table->time('imsak_zaman');
			$table->time('gunes_zaman');
			$table->time('ogle_zaman');
			$table->time('ikindi_zaman');
			$table->time('aksam_zaman');
			$table->time('yatsi_zaman');
			$table->time('kible');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('PrayerTimes');
	}

}
