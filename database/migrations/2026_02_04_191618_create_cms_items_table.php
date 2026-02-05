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
        Schema::create('cms_items', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['page', 'email_template', 'snippet'])->default('page');
            $table->enum('locale', ['fr', 'en'])->default('fr');
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('content');
            $table->json('metadata')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_items');
    }
};
