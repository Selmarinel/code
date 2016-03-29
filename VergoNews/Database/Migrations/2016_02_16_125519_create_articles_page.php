<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesPage extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('articles');
		Schema::create('articles', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('user_id');
			$table->string('name');
			$table->string('info')->default('');
			$table->longText('text');
			$table->boolean('is_hot_topic')->default(false);
			$table->unsignedInteger('image_id')->nullable();
			$table->unsignedInteger('category_id');
			$table->timestamps();
			$table->tinyInteger('status')->default(0); //0 -unpublished, 1 - published, 2 - hidden
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('articles');
	}
}
