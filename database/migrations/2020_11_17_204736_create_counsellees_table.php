<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCounselleesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counsellees', function (Blueprint $table) {
            $table->id();
            $table->string('username', 15)->unique();
            $table->string('email', 191)->unique();
            $table->string('password', 191);
            $table->string('firstname', 50)->nullable();
            $table->string('lastname', 50)->nullable();
            $table->date('dob')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('counsellees');
    }
}
