<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Informações do cliente
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('table_number')->nullable();
            
            // Status e pagamento
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])
                  ->default('pending');
            $table->enum('payment_method', ['cash', 'card', 'pix', 'other'])
                  ->nullable();
            
            // Valores
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            
            // Observações
            $table->text('notes')->nullable();
            
            // Timestamps
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['company_id', 'status']);
            $table->index(['company_id', 'created_at']);
            $table->index(['company_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
