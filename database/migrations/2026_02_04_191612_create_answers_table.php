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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('cms_questions')->cascadeOnDelete();
            $table->text('value')->nullable(); // for QCM/boolean
            $table->json('custom_value')->nullable(); // for text/custom responses
            $table->boolean('is_custom')->default(false);
            $table->string('evidence_url')->nullable(); // optional file attachment
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
