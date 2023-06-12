<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('DutyRosters', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 100);
            $table->integer('week');
            $table->date('date', 9, 2);
            $table->string('status',100)->nullable()->change();
            $table->time('start_time',0);
            $table->time('end_time',0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DutyRosters');
    }
};
