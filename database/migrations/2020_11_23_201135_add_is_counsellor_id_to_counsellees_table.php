<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsCounsellorIdToCounselleesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('counsellees', function (Blueprint $table) {
            $table->foreignId('is_counsellor')->nullable()->after('dob')->constrained('counsellors')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('counsellees', function (Blueprint $table) {
            $table->dropForeign(['is_counsellor']);
        });
    }
}
