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
        Schema::create('final_job_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('ijp_id');
            $table->string("applicant_id")->nullable();
            $table->string('applicant')->nullable();
            $table->date('release_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('unit')->nullable();
            $table->string('job_title')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->nullable();
            $table->text('qualifications')->nullable();
            $table->string('experience')->nullable();
            $table->string('new_or_replacement')->nullable();
            $table->string('interview_panel')->nullable();
            $table->date('interview_date')->nullable();
            $table->string('interview_result')->nullable();
            $table->text('communication_result')->nullable();
            $table->text('communication_movement')->nullable();
            $table->string('salary_increase')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('required_position')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_job_statuses');
    }
};
