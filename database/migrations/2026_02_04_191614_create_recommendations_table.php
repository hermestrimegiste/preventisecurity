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
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->enum('impact', ['low', 'medium', 'high'])->default('medium');
            $table->enum('effort', ['small', 'medium', 'large'])->default('medium');
            $table->enum('horizon', ['0-30j', '30-90j', '3-6mois'])->default('30-90j');
            $table->string('cost_range')->nullable(); // €, €€, €€€
            $table->integer('order')->default(0); // Priority order
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};
