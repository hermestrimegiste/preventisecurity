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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('consultant_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('provider', ['cal_com', 'calendly', 'google'])->default('cal_com');
            $table->string('provider_booking_id')->nullable(); // External ID
            $table->timestamp('slot_start')->nullable();
            $table->timestamp('slot_end')->nullable();
            $table->string('timezone')->default('Europe/Paris');
            $table->string('meeting_link')->nullable(); // Video call URL
            $table->enum('status', ['scheduled', 'completed', 'cancelled', 'no_show'])->default('scheduled');
            $table->timestamp('reminder_sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
