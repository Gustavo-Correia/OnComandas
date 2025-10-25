<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('restrict');
            
            // Informações do produto no momento da venda
            $table->string('product_name'); // Nome do produto (snapshot)
            $table->string('product_sku')->nullable(); // SKU (snapshot)
            
            // Quantidade e preços
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2); // Preço unitário na venda
            $table->decimal('subtotal', 10, 2); // quantity * unit_price
            
            // Desconto (opcional)
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2); // subtotal - discount
            
            // Observações
            $table->text('notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['company_id', 'order_id']);
            $table->index(['company_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
