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

        Schema::create('asset_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('category_id');
            $table->enum('priority', ['Very Urgent','Urgent','Very High','High','Medium','Low']);
            $table->string('unit');
            $table->string('division');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->timestamp('assigned_on')->nullable();
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->timestamp('changed_on')->nullable();
            $table->unsignedBigInteger('closed_by')->nullable();
            $table->timestamp('closed_on')->nullable();
            $table->unsignedBigInteger('reopened_by')->nullable();
            $table->timestamp('reopened_on')->nullable();
            $table->enum('status', ['Yet to Assigned', 'In Progress', 'On Hold', 'Completed', 'Closed', 'Reopened'])
                  ->default('Yet to Assigned');
            $table->timestamps(); // created_at and updated_at
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_tickets');
    }
};
