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
        Schema::create('role_unit_permissions', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('role_id');
        $table->unsignedBigInteger('unit_id');
        $table->foreignId('module_id')->references('id')->on('modules')->onDelete('cascade');
        $table->foreignId('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        $table->timestamps();

        $table->unique(['role_id', 'unit_id', 'permission_id']);

        $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');

    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_unit_permissions');
    }
};
