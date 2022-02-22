<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkMeetingParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_meeting_participants', function (Blueprint $table) {
            $table->increments('wmp_id');
            $table->unsignedInteger('wm_id')->comment('Work Meeting');
            $table->unsignedInteger('employee_id')->comment('Employee');
            $table->tinyInteger('wmp_absence_status')->default(2)->comment('1 = Absence, 2 = Not Absence');
            $table->dateTime('wmp_datetime_absence')->nullable();
            $table->string('wmp_absence_note', 255)->nullable();
            $table->tinyInteger('wmp_is_minutes')->default(2)->comment('1 = Yes, 2 = No');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('wm_id')->references('wm_id')->on('work_meetings')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('employee_id')->references('employee_id')->on('employees')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_meeting_participants');
    }
}
