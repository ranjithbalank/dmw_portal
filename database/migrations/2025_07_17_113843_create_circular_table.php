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
        Schema::create('circulars', function (Blueprint $table) {
            $table->id();
            $table->string("circular_no")->unique();
            $table->date("circular_date");
            $table->string("created_by");
            $table->string("file_path");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circular');
    }
};
