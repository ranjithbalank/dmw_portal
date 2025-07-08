<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('asset_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('category_id'); // You may have a categories table
            $table->enum('priority', ['Very Urgent', 'Urgent', 'Very High', 'High', 'Medium', 'Low']);
            $table->string('unit');
            $table->string('division');
            $table->string('closed_reason')->nullable();
            $table->string('reopened_reason')->nullable();

            // Foreign keys to users table
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->unsignedBigInteger('assigned_by')->nullable();
            $table->unsignedBigInteger('closed_by')->nullable();
            $table->unsignedBigInteger('reopened_by')->nullable();

            $table->timestamp('assigned_on')->nullable();
            $table->timestamp('changed_on')->nullable();
            $table->timestamp('closed_on')->nullable();
            $table->timestamp('reopened_on')->nullable();

            $table->enum('status', ['Yet to Assigned', 'Assigned','In Progress', 'On Hold', 'Completed', 'Closed', 'Reopen'])
                ->default('Yet to Assigned');

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            $table->foreign('assigned_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('closed_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('reopened_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_tickets');
    }
};
