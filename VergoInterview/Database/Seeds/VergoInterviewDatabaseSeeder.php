<?php
namespace App\Modules\VergoInterview\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class VergoInterviewDatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// $this->call('App\Modules\VergoInterview\Database\Seeds\FoobarTableSeeder');
	}

}
