<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes, BelongsToCompany;

    protected $fillable = [
        'company_id',
        'name',
        'slug',
        'description',
        'sku',
        'price',
        'cost',
        'stock',
        'min_stock',
        'category_id',
        'image',
        'active',
        'featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost' => 'decimal:2',
        'stock' => 'integer',
        'min_stock' => 'integer',
        'active' => 'boolean',
        'featured' => 'boolean',
    ];

    /**
     * Boot do model - adiciona Global Scope
     */
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);

        // Gera slug automaticamente ao criar
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        // Atualiza slug ao modificar nome
        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * Relacionamento com Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relacionamento com Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relacionamento com OrderItems (produtos vendidos)
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'min_stock');
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('sku', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    /**
     * Acessores (Getters)
     */
    public function getProfitAttribute()
    {
        if ($this->cost) {
            return $this->price - $this->cost;
        }
        return null;
    }

    public function getProfitMarginAttribute()
    {
        if ($this->cost && $this->price > 0) {
            return (($this->price - $this->cost) / $this->price) * 100;
        }
        return null;
    }

    public function getIsLowStockAttribute()
    {
        return $this->stock <= $this->min_stock;
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/no-image.png');
    }

    /**
     * Métodos auxiliares
     */
    public function decreaseStock(int $quantity): bool
    {
        if ($this->stock >= $quantity) {
            $this->decrement('stock', $quantity);
            return true;
        }
        return false;
    }

    public function increaseStock(int $quantity): void
    {
        $this->increment('stock', $quantity);
    }

    public function setPrice(float $price): void
    {
        $this->update(['price' => $price]);
    }

    public function toggleActive(): void
    {
        $this->update(['active' => !$this->active]);
    }

    public function toggleFeatured(): void
    {
        $this->update(['featured' => !$this->featured]);
    }
}
