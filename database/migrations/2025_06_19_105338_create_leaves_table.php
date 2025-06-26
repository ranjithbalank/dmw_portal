
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

            $table->enum('leave_type', ['casual', 'sick', 'earned', 'comp-off', 'od', 'permission'])
                ->default('casual');
            $table->enum('leave_duration', ['Full Day', 'Half Day']);

            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->date('comp_off_worked_date')->nullable();
            $table->date('comp_off_leave_date')->nullable();

            $table->decimal('leave_days', 4, 2);
            $table->text('reason')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
