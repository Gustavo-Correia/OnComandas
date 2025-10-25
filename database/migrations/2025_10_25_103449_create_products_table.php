<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            
            // Informações básicas
            $table->string('name');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->string('sku')->nullable(); // Código do produto
            
            // Preços
            $table->decimal('price', 10, 2);
            $table->decimal('cost', 10, 2)->nullable(); // Custo do produto
            
            // Estoque
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(0); // Estoque mínimo
            
            // Categoria e imagem
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('image')->nullable();
            
            // Status
            $table->boolean('active')->default(true);
            $table->boolean('featured')->default(false); // Produto em destaque
            
            $table->timestamps();
            $table->softDeletes();

            // Índices para performance
            $table->index(['company_id', 'active']);
            $table->index(['company_id', 'category_id']);
            $table->index(['company_id', 'name']);
            $table->index(['company_id', 'sku']);
            $table->unique(['company_id', 'sku']); // SKU único por empresa
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
