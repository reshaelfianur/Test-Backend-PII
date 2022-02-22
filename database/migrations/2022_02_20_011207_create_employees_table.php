<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('employee_id');
            // $table->unsignedInteger('religion_id')->comment('Religion);
            // $table->unsignedInteger('ms_id')->comment('Marital Status);
            // $table->unsignedInteger('origin_id')->comment('Origin);
            // $table->unsignedInteger('pr_id')->comment('Probation Result);
            // $table->unsignedInteger('jt_id')->comment('Job Title);
            // $table->unsignedInteger('grade_id')->comment('Grade);
            // $table->unsignedInteger('team_id')->comment('Team);
            $table->string('employee_code', 25);
            $table->string('employee_first_name', 50);
            $table->string('employee_last_name', 50)->nullable()->default(null);
            // $table->string('employee_id_card', 25)->nullable()->default(null);
            // $table->string('employee_passport_no', 25)->nullable()->default(null);
            $table->string('employee_phone_no', 25)->nullable()->default(null);
            // $table->string('employee_nation', 50)->nullable()->default(null);
            // $table->tinyInteger('employee_gender')->nullable()->comment('1 = Male, 2 = Female');
            // $table->date('employee_birth_date')->nullable()->default(null);
            // $table->string('employee_birth_place', 50)->nullable()->default(null);
            // $table->string('employee_email_private', 120)->nullable()->default(null);
            // $table->string('employee_email_company', 120)->nullable()->default(null);
            // $table->tinyInteger('employee_is_retire')->nullable()->default('2')->comment('1 = Yes, 2 = No');
            // $table->date('employee_retire_date')->nullable()->default(null);
            // $table->date('employee_join_date')->nullable()->default(null);
            // $table->date('employee_probation_end_date')->nullable()->default(null);
            // $table->date('employee_permanent_date')->nullable()->default(null);
            // $table->date('employee_resign_date')->nullable()->default(null);
            // $table->text('employee_picture')->nullable()->default(null);

            // $table->integer('created_by')->nullable()->default(null);
            // $table->integer('updated_by')->nullable()->default(null);
            // $table->integer('deleted_by')->nullable()->default(null);

            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('origin_id')->references('origin_id')->on('originations')
            //     ->onDelete('restrict')
            //     ->onUpdate('restrict');

            // $table->foreign('religion_id')->references('religion_id')->on('religions')
            //     ->onDelete('restrict')
            //     ->onUpdate('restrict');

            // $table->foreign('ms_id')->references('ms_id')->on('marital_status')
            //     ->onDelete('restrict')
            //     ->onUpdate('restrict');

            // $table->foreign('grade_id')->references('grade_id')->on('grades')
            //     ->onDelete('restrict')
            //     ->onUpdate('restrict');

            // $table->foreign('jt_id')->references('jt_id')->on('job_titles')
            //     ->onDelete('restrict')
            //     ->onUpdate('restrict');

            // $table->foreign('team_id')->references('team_id')->on('teams')
            //     ->onDelete('restrict')
            //     ->onUpdate('restrict');

            // $table->foreign('pr_id')->references('pr_id')->on('probation_results')
            //     ->onDelete('no action')
            //     ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
