<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->integer('technical_staff_id')->unsigned()->nullable()->after('status_id');
            $table->foreign('technical_staff_id')->references('id')->on('technical_staff')->onDelete('set null');
            $table->integer('company_id')->unsigned()->nullable()->after('user_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            $table->integer('work_time')->nullable()->after('status_id')->comment('Tiempo de trabajo en minutos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['technical_staff_id']);
            $table->dropForeign(['company_id']);
            $table->dropColumn(['technical_staff_id', 'company_id', 'work_time']);
        });
    }
}
