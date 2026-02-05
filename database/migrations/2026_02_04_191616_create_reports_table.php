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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->cascadeOnDelete();
            $table->json('json_blob')->nullable(); // Structured AI output
            $table->string('pdf_url')->nullable(); // S3/storage path
            $table->string('web_url')->nullable(); // HTML version URL
            $table->string('share_token')->unique()->nullable(); // For secure sharing
            $table->timestamp('expires_at')->nullable(); // Link expiration
            $table->timestamp('generated_at')->nullable();
            $table->string('ai_prompt_version')->nullable(); // Versioning
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
