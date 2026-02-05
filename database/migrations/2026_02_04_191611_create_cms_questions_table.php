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
        Schema::create('cms_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('cms_sections')->cascadeOnDelete();
            $table->text('question_text');
            $table->text('help_text')->nullable();
            $table->string('help_link')->nullable();
            $table->enum('assessment_level', ['express', 'detailed', 'both'])->default('both');
            $table->enum('answer_type', ['single_choice', 'multiple_choice', 'text', 'boolean'])->default('single_choice');
            $table->json('options')->nullable(); // for QCM
            $table->json('dependencies')->nullable(); // conditional display rules
            $table->decimal('weight', 5, 2)->default(1.00); // for scoring
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_questions');
    }
};
