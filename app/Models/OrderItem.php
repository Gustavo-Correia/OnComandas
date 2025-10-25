<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes, BelongsToCompany;

    protected $fillable = [
        'company_id',
        'order_id',
        'product_id',
        'product_name',
        'product_sku',
        'quantity',
        'unit_price',
        'subtotal',
        'discount',
        'total',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Boot do model - adiciona Global Scope e cálculos automáticos
     */
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);

        // Preenche dados do produto automaticamente ao criar
        static::creating(function ($orderItem) {
            if ($orderItem->product_id && !$orderItem->product_name) {
                $product = Product::find($orderItem->product_id);
                
                if ($product) {
                    $orderItem->product_name = $product->name;
                    $orderItem->product_sku = $product->sku;
                    $orderItem->unit_price = $orderItem->unit_price ?? $product->price;
                }
            }

            // Calcula subtotal
            $orderItem->subtotal = $orderItem->quantity * $orderItem->unit_price;
            
            // Calcula total
            $orderItem->total = $orderItem->subtotal - ($orderItem->discount ?? 0);
        });

        // Recalcula ao atualizar
        static::updating(function ($orderItem) {
            if ($orderItem->isDirty(['quantity', 'unit_price', 'discount'])) {
                $orderItem->subtotal = $orderItem->quantity * $orderItem->unit_price;
                $orderItem->total = $orderItem->subtotal - ($orderItem->discount ?? 0);
            }
        });

        // Atualiza estoque ao criar
        static::created(function ($orderItem) {
            if ($orderItem->product_id) {
                $product = Product::find($orderItem->product_id);
                $product?->decreaseStock($orderItem->quantity);
            }
        });

        // Restaura estoque ao deletar
        static::deleted(function ($orderItem) {
            if ($orderItem->product_id) {
                $product = Product::find($orderItem->product_id);
                $product?->increaseStock($orderItem->quantity);
            }
        });
    }

    /**
     * Relacionamentos
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Acessores (Getters)
     */
    public function getFormattedUnitPriceAttribute()
    {
        return 'R$ ' . number_format($this->unit_price, 2, ',', '.');
    }

    public function getFormattedSubtotalAttribute()
    {
        return 'R$ ' . number_format($this->subtotal, 2, ',', '.');
    }

    public function getFormattedTotalAttribute()
    {
        return 'R$ ' . number_format($this->total, 2, ',', '.');
    }

    public function getFormattedDiscountAttribute()
    {
        return 'R$ ' . number_format($this->discount, 2, ',', '.');
    }

    /**
     * Métodos auxiliares
     */
    public function applyDiscount(float $discount): void
    {
        $this->update([
            'discount' => $discount,
            'total' => $this->subtotal - $discount,
        ]);
    }

    public function updateQuantity(int $quantity): void
    {
        $oldQuantity = $this->quantity;
        $difference = $quantity - $oldQuantity;

        $this->update(['quantity' => $quantity]);

        // Atualiza estoque
        if ($difference > 0) {
            $this->product->decreaseStock($difference);
        } else {
            $this->product->increaseStock(abs($difference));
        }
    }
}
