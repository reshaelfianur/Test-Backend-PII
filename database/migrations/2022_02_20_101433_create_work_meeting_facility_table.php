<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkMeetingFacilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_meeting_facility', function (Blueprint $table) {
            $table->unsignedInteger('wm_id')->comment('Work Meeting');
            $table->unsignedInteger('facility_id')->comment('Facility');

            $table->foreign('wm_id')->references('wm_id')->on('work_meetings')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('facility_id')->references('facility_id')->on('facilities')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_meeting_facility');
    }
}
