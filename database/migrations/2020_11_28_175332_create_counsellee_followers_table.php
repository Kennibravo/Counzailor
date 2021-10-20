<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCounselleeFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counsellee_followers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counsellee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('following_counsellor')->constrained('counsellors')->cascadeOnDelete();
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
        Schema::dropIfExists('counsellee_followers');
    }
}
