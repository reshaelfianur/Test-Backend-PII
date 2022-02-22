<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_meetings', function (Blueprint $table) {
            $table->increments('wm_id');
            $table->unsignedInteger('room_id')->comment('Room');
            $table->string('wm_name', 50);
            $table->string('wm_description', 255);
            $table->dateTime('wm_datetime_in');
            $table->dateTime('wm_datetime_out');
            $table->integer('wm_number_of_participants');
            $table->tinyInteger('wm_agreement_status')->default(1)->comment('1 = On Progress, 2 = Approved, 3 = Not Approved');
            $table->string('wm_agreement_note', 255)->nullable();

            $table->unsignedInteger('created_by')->nullable()->comment('User');
            $table->unsignedInteger('updated_by')->nullable()->comment('User');
            $table->unsignedInteger('deleted_by')->nullable()->comment('User');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('room_id')->references('room_id')->on('rooms')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('created_by')->references('user_id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('updated_by')->references('user_id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('deleted_by')->references('user_id')->on('users')
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
        Schema::dropIfExists('work_meetings');
    }
}
