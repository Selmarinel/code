<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\VergoBase\Database\Models\Module;

class UpdateModule11 extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Module::query()->where('name','VergoNews')->update(['version'=>'1.1']);
		Schema::table('categories', function (Blueprint $table) {
			$table->boolean('is_main')->default(false);
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
