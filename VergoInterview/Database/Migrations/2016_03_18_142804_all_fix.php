<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllFix extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('interview_responders');
		Schema::table('interviews', function (Blueprint $table) {
			$table->string('respondent_first_name');
			$table->string('respondent_last_name');
			$table->string('respondent_position');
			$table->integer('respondent_cover_id');
		});
		Schema::dropIfExists('interview_dialogs');
		Schema::create('interview_dialogs', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('interview_id')->references('id')->on('interviews');
			$table->longText('question');
			$table->longText('answer');
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

	}
}
