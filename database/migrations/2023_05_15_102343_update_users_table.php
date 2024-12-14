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
        // Add new columns
        Schema::table('users', function (Blueprint $table) {
            $table->string('matric_id')->nullable();
            $table->integer('phone_num')->nullable();
            $table->string('role')->default('admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(array_merge([
                'matric_id',
                'phone_num',
                'role',
            ]));
        });
    }
};
