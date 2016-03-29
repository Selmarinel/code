<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\VergoNews\Database\Models\CategoryModel as Model;

class CreateCategories extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('categories');
		Schema::create('categories', function (Blueprint $table) {
			$table->increments('id');
			$table->char('color', 6);
			$table->string('name');
			$table->tinyInteger('status')->default(1);
		});
		Model::create(['color'=>'f000f0','name'=>'Новые']);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('categories');
	}
}
