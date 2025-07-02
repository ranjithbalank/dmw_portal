<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->enum('leave_type', ["N/A",'casual', 'sick', 'earned', 'comp-off', 'od', 'permission'])
                ->default('N/A')->nullable();
            $table->enum('leave_duration', ['N/A','Full Day', 'Half Day'])->nullable();

            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->date('comp_off_worked_date')->nullable();
            $table->date('comp_off_leave_date')->nullable();

            $table->decimal('leave_days', 4, 2);
            $table->text('reason')->nullable();

            // Approver details & comments
            $table->text('approver_1')->nullable(); // usually manager name or ID
            $table->text('approver_2')->nullable(); // usually HR/Admin name or ID

            $table->timestamp('approver_1_approved_at')->nullable();
            $table->timestamp('approver_2_approved_at')->nullable();

            $table->text('approver_1_comments')->nullable();
            $table->text('approver_2_comments')->nullable();

            // Single status column to track workflow
            $table->enum('status', [
                'pending',                      // waiting for manager
                'supervisor/ manager approved', // manager approved, waiting for HR
                'supervisor/ manager rejected',
                'hr approved',
                'hr rejected',
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
