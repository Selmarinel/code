<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixDialogs extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('interview_dialogs');
		Schema::create('interview_dialogs', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('interview_id')->references('id')->on('interviews');
			$table->integer('responder_id')->references('id')->on('interview_responders');
			$table->longText('question');
			$table->longText('answer');
			$table->timestamps();
		});
		Schema::table('interview_responders', function (Blueprint $table) {
			$table->tinyInteger('status')->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('interview_dialogs');
	}
}
