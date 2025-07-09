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
        Schema::table('leaves', function (Blueprint $table) {
        // Drop old columns
        $table->dropColumn(['approver_1', 'approver_2']);
    });

    Schema::table('leaves', function (Blueprint $table) {
        $table->unsignedBigInteger('approver_1')->nullable();
        $table->unsignedBigInteger('approver_2')->nullable();

        $table->foreign('approver_1')->references('id')->on('users')->nullOnDelete();
        $table->foreign('approver_2')->references('id')->on('users')->nullOnDelete();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foreign_keys', function (Blueprint $table) {
            //
        });
    }
};
