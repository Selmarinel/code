<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReloadMind extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('interviews');
		Schema::dropIfExists('interview_responders');
		Schema::dropIfExists('interview_dialogs');
		Schema::create('responders', function (Blueprint $table) {
			$table->increments('id');
			$table->string('first_name',50);
			$table->string('last_name',70);
			$table->string('position',50);
			$table->integer('cover_id');
		});
		Schema::create('interviews', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->references('id')->on('users');
			$table->integer('responder_id')->references('id')->on('responders');
			$table->tinyInteger('status')->default(1);
			$table->timestamps();
		});
		Schema::table('articles', function (Blueprint $table) {
			$table->integer('interview_id')->references('id')->on('interviews');
		});
		Schema::create('interview_dialogs', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('interview_id')->references('id')->on('interviews');
			$table->mediumText('question');
			$table->longText('answer');
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

	}
}
