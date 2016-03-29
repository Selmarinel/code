<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\VergoBase\Database\Models\Module;

class InitModuleNews extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Module::create([
			'name'				=> 'VergoNews',
			'info' 				=> 'VergoNews Module for [VERGO] Engine',
			'version' 			=> 1,
			'install_version' 	=> 1,
			'status' 			=> 1
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Module::query()->where('name','VergoNews')->delete();
	}
}
