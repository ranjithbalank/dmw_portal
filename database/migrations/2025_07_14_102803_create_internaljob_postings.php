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
        Schema::create('internal_jobpostings', function (Blueprint $table) {
            $table->id();
            $table->string('job_title');
            $table->text('job_description');
            $table->string('qualifications');
            $table->string('work_experience');
            $table->string('slot_available');
            $table->string('unit');
            $table->string('division');
            $table->date('passing_date');
            $table->date('end_date')->nullable(); // Assuming 'end_date' is nullable
            $table->string('status')->default('active'); // Adding status field with default value

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internaljob_postings');
    }
};
