<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateNglsTable.
 */
class CreateNglsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ngls', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('md_id')->index();
            $table->boolean('auto_orient')->default(false);
            $table->string('orient');
            $table->string('trj_selection');
            $table->integer('initial_frame');
            $table->boolean('centre_pdb')->default(false);
            $table->boolean('remove_pbc')->default(false);
            $table->boolean('superpose')->default(false);;
            $table->integer('step');
            $table->string('mode');
            $table->string('direction');
            $table->integer('interpolate_step');
            $table->string('interpolate_type');

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
		Schema::drop('ngls');
	}
}
