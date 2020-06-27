<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('times', function (Blueprint $table) {
            $table->bigInteger('project_id');
            $table->string('description');
        });

        // Migrating data
        DB::update('UPDATE times, tasks SET times.project_id = tasks.project_id, times.description = tasks.name WHERE times.task_id = tasks.id');

        Schema::table('times', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects');
        });

        Schema::table('times', function (Blueprint $table) {
            $table->dropForeign([ 'task_id' ]);
            $table->dropColumn('task_id');
        });

        Schema::dropIfExists('tasks');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
