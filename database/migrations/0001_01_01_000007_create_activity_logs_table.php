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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->string('activity_type')->default('QR_SCAN'); // QR_SCAN, ROOM_VISIT, etc.
            $table->text('activity_description')->nullable();
            $table->timestamp('scan_time'); // Time when the QR code was scanned
            $table->string('status')->default('COMPLETED'); // COMPLETED, PENDING, etc.
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
