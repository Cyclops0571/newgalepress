<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApplicationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Application', function(Blueprint $table)
		{
			$table->increments('ApplicationID');
			$table->integer('CustomerID')->unsigned()->nullable();
			$table->string('Name')->nullable();
			$table->string('Detail', 1000)->nullable();
			$table->string('ApplicationLanguage', 32);
			$table->integer('ThemeBackground')->default(1);
			$table->integer('ThemeForeground')->default(1);
			$table->string('ThemeForegroundColor', 10)->default('#0082CA');
			$table->decimal('Price')->default(118.00);
			$table->integer('Installment')->unsigned()->default(24);
			$table->integer('InAppPurchaseActive')->default(0);
			$table->integer('FlipboardActive')->default(0);
			$table->integer('BreadCrumbActive')->default(0);
			$table->string('BundleText');
			$table->date('StartDate')->nullable();
			$table->dateTime('ExpirationDate')->nullable();
			$table->integer('ApplicationStatusID')->unsigned()->nullable();
			$table->integer('IOSVersion')->nullable();
			$table->string('IOSLink')->nullable();
			$table->string('IOSHexPasswordForSubscription');
			$table->integer('AndroidVersion')->nullable();
			$table->string('AndroidLink')->nullable();
			$table->integer('PackageID')->unsigned()->nullable();
			$table->integer('Blocked')->unsigned()->nullable();
			$table->integer('Status')->unsigned()->nullable();
			$table->integer('Trail')->unsigned()->default(2);
			$table->integer('Version')->unsigned()->nullable();
			$table->smallInteger('Force')->unsigned()->default(0);
			$table->integer('TotalFileSize')->unsigned()->nullable();
			$table->string('NotificationText')->nullable();
			$table->string('CkPem')->nullable();
			$table->integer('BannerActive')->default(0);
			$table->integer('BannerRandom');
			$table->integer('BannerCustomerActive')->unsigned();
			$table->string('BannerCustomerUrl');
			$table->integer('BannerAutoplay')->default(1);
			$table->integer('BannerIntervalTime')->default(5000);
			$table->integer('BannerTransitionRate')->default(2000);
			$table->string('BannerColor', 10);
			$table->string('BannerSlideAnimation', 45)->default('slide');
			$table->integer('TabActive')->default(0);
			$table->string('GoogleDeveloperKey');
			$table->string('GoogleDeveloperEmail');
			$table->integer('SubscriptionWeekActive');
			$table->string('WeekIdentifier');
			$table->integer('SubscriptionMonthActive');
			$table->string('MonthIdentifier');
			$table->integer('SubscriptionYearActive');
			$table->string('YearIdentifier');
			$table->smallInteger('ShowDashboard')->unsigned()->default(0);
			$table->text('ConfirmationMessage', 65535);
			$table->integer('TopicStatus')->unsigned()->default(0);
			$table->integer('StatusID')->unsigned()->nullable();
			$table->integer('CreatorUserID')->unsigned()->nullable();
			$table->dateTime('DateCreated')->nullable();
			$table->integer('ProcessUserID')->unsigned()->nullable();
			$table->dateTime('ProcessDate')->nullable();
			$table->integer('ProcessTypeID')->unsigned()->nullable();
			$table->index(['CustomerID','StatusID'], 'CustomerID');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Application');
	}

}
