<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade');
            
            // Informações básicas
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            
            // Ícone/Imagem
            $table->string('icon')->nullable(); // Ex: 'pizza', 'burger', 'drink'
            $table->string('image')->nullable();
            $table->string('color')->nullable(); // Cor hexadecimal para UI
            
            // Ordenação e status
            $table->integer('order')->default(0);
            $table->boolean('active')->default(true);
            
            $table->timestamps();
            $table->softDeletes();

            // Índices para performance
            $table->index(['company_id', 'active']);
            $table->index(['company_id', 'parent_id']);
            $table->index(['company_id', 'slug']);
            $table->index(['company_id', 'order']);
            $table->unique(['company_id', 'slug']); // Slug único por empresa
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
