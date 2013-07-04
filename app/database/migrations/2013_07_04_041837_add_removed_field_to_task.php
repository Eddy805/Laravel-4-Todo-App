<?php

use Illuminate\Database\Migrations\Migration;

class AddRemovedFieldToTask extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tasks', function($table){
			$table->boolean('removed')->default(false);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tasks', function($table){
			$table->dropColumn('removed');
		});
	}

}