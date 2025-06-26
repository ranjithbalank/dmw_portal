<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Clean invalid manager_id references
        DB::statement('
        UPDATE users
        SET manager_id = NULL
        WHERE manager_id IS NOT NULL
        AND manager_id NOT IN (SELECT id FROM (SELECT id FROM users) AS valid_ids)
    ');

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('manager_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
