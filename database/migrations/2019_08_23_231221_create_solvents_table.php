<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSolventsTable.
 */
class CreateSolventsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('solvents', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('md_id')->index();
            $table->string('name');
            $table->string('chemical');
            $table->integer('n');

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
		Schema::drop('solvents');
	}
}
