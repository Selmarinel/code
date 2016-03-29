<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\VergoBase\Database\Models\Module;


class InitModule extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Module::create([
			'name'				=> 'VergoInterview',
			'info' 				=> 'Interview Module for [VERGO] Core',
			'version' 			=> 1,
			'install_version' 	=> 1,
			'status' 			=> 1
		]);
		Schema::dropIfExists('interviews');
		Schema::create('interviews', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('article_id')->references('id')->on('articles');
			$table->integer('user_id')->references('id')->on('users');
			$table->tinyInteger('status')->default(0);
			$table->timestamps();
		});
		Schema::dropIfExists('interview_responders');
		Schema::create('interview_responders', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('interview_id')->references('id')->on('interviews');
			$table->string('name');
			$table->string('place');
			$table->integer('file_id')->references('id')->on('files');
		});
		Schema::dropIfExists('interview_dialogs');
		Schema::create('interview_dialogs', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('responder_id')->references('id')->on('interview_responders');
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
		Schema::dropIfExists('interviews');
		Schema::dropIfExists('interview_responders');
		Schema::dropIfExists('interview_dialogs');
	}
}
