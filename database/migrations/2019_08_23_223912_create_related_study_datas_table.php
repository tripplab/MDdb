<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRelatedStudyDatasTable.
 */
class CreateRelatedStudyDatasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('related_study_datas', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('study_id')->index();
            $table->string('name');
            $table->string('url');

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
		Schema::drop('related_study_datas');
	}
}
