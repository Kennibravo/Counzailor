<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counsellee_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('counsellor_id')->nullable()->constrained()->cascadeOnDelete();
            //Replying to Message ID
            $table->bigInteger('replying_to')->nullable();
            $table->text('content');
            $table->boolean('is_read')->default(0);
            $table->foreignId('chat_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('messages');
    }
}
