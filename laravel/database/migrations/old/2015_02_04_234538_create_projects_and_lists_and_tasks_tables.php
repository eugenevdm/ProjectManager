<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateProjectsAndListsAndTasksTables extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->default('');
			$table->string('slug')->default('');
            $table->text('description')->default('');
			$table->timestamps();
		});
        Schema::create('lists', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('project_id')->unsigned()->default(0);
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->string('name')->default('');
            $table->string('slug')->default('');
            $table->text('description')->default('');
            $table->timestamps();
        });
		Schema::create('tasks', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('list_id')->unsigned()->default(0);
			$table->foreign('list_id')->references('id')->on('lists')->onDelete('cascade');
			$table->string('name')->default('');
			$table->string('slug')->default('');
            $table->boolean('priority')->default(false);
            $table->boolean('completed')->default(false);
			$table->text('description')->default('');
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
		Schema::drop('tasks');
		Schema::drop('projects');
	}
}