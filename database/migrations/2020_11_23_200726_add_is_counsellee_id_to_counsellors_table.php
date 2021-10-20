<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsCounselleeIdToCounsellorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('counsellors', function (Blueprint $table) {
            $table->foreignId('is_counsellee')->nullable()->after('dob')->constrained('counsellees')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('counsellors', function (Blueprint $table) {
            $table->dropForeign(['is_counsellee']);
        });
    }
}
