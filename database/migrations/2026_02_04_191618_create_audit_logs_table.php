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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('action', ['view', 'create', 'update', 'delete', 'export'])->default('view');
            $table->string('entity'); // Model name
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->json('changes')->nullable(); // Before/after state
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('timestamp')->useCurrent();
            
            $table->index(['entity', 'entity_id']);
            $table->index('actor_id');
            $table->index('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
