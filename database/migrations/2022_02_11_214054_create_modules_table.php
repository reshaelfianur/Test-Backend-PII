<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('mod_id');
            $table->string('mod_code', 25);
            $table->string('mod_name', 50);
            $table->string('mod_icon', 50)->nullable()->default(null);
            $table->tinyInteger('mod_status')->default(1)->comment('1 = Active, 2 = Not Active');

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
        Schema::dropIfExists('modules');
    }
}
