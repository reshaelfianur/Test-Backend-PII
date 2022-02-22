<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinutesOfMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('minutes_of_meetings', function (Blueprint $table) {
            $table->increments('mom_id');
            $table->unsignedInteger('wm_id')->comment('Work Meeting');
            $table->unsignedInteger('wmp_id')->comment('Work Meeting Participant');
            $table->text('mom_result_of_meeting', 255)->nullable();
            $table->tinyInteger('mom_note_status')->default(2)->comment('1 = Publish, 2 = Not Publish');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('wm_id')->references('wm_id')->on('work_meetings')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('wmp_id')->references('wmp_id')->on('work_meeting_participants')
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
        Schema::dropIfExists('minutes_of_meetings');
    }
}
