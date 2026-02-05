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
        Schema::create('respondents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('email')->unique();
            $table->string('role')->nullable(); // CEO, CFO, CIO, DSI, RSSI, etc.
            $table->string('company_name')->nullable();
            $table->enum('locale', ['fr', 'en'])->default('fr');
            $table->string('magic_link_token')->nullable()->unique();
            $table->timestamp('magic_link_expires_at')->nullable();
            $table->timestamp('consent_gdpr_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respondents');
    }
};
