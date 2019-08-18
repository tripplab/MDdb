<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMolecularDynamicsTable.
 */
class CreateMolecularDynamicsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('molecular_dynamics', function(Blueprint $table) {
            $table->increments('id');

			$table->uuid('uuid')->index();
			$table->string('name');
			$table->text('description')->nullable();
			$table->jsonb('positions');
			$table->double('ns', 32, 2)->nullable();
			$table->jsonb('data')->nullable();

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
		Schema::drop('molecular_dynamics');
	}
}
