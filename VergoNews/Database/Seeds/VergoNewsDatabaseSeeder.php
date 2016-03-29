<?php
namespace App\Modules\VergoNews\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class VergoNewsDatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// $this->call('App\Modules\VergoNews\Database\Seeds\FoobarTableSeeder');
	}

}
