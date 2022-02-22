<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalAccessTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('personal_access_tokens');
        
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            // $table->morphs('tokenable');
            $table->string('tokenable_type');
            $table->unsignedInteger('tokenable_id')->comment('User');
            $table->foreign('tokenable_id')->references('user_id')->on('users');
            // end table morphs
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
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
        Schema::dropIfExists('personal_access_tokens');
    }
}
