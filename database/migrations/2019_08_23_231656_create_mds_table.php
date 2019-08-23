<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMdsTable.
 */
class CreateMdsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mds', function(Blueprint $table) {
            $table->increments('id');
            $table->date('approved_at')->nullable();
            $table->binary('coords');
            $table->binary('traj');
            $table->string('name');
            $table->integer('total_atoms')->default(0);
            $table->float('temperature')->default(0);
            $table->float('box_x')->default(0);
            $table->float('box_y')->default(0);
            $table->float('box_z')->default(0);
            $table->float('length')->default(0);
            $table->float('performance')->default(0);

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
		Schema::drop('mds');
	}
}
