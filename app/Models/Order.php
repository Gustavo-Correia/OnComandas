<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes, BelongsToCompany;

    protected $fillable = [
        'company_id',
        'user_id',
        'customer_name',
        'customer_phone',
        'table_number',
        'status',
        'payment_method',
        'subtotal',
        'discount',
        'total',
        'notes',
        'completed_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    /**
     * Boot do model
     */
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);

        // Recalcula total ao atualizar itens
        static::saved(function ($order) {
            $order->recalculateTotal();
        });
    }

    /**
     * Relacionamentos
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Métodos auxiliares
     */
    public function recalculateTotal(): void
    {
        $this->subtotal = $this->items->sum('subtotal');
        $this->total = $this->items->sum('total');
        $this->saveQuietly(); // Salva sem disparar eventos
    }

    public function addItem(Product $product, int $quantity, ?float $discount = 0): OrderItem
    {
        return $this->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $product->price,
            'discount' => $discount,
        ]);
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function markAsCancelled(): void
    {
        $this->update(['status' => 'cancelled']);
    }
}
