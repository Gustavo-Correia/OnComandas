<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes, BelongsToCompany;

    protected $fillable = [
        'company_id',
        'parent_id',
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'color',
        'order',
        'active',
    ];

    protected $casts = [
        'order' => 'integer',
        'active' => 'boolean',
    ];

    protected $with = ['parent']; // Eager load parent por padrão

    /**
     * Boot do model
     */
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);

        // Gera slug automaticamente ao criar
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }

            // Define ordem automática se não especificada
            if (is_null($category->order)) {
                $maxOrder = static::where('company_id', $category->company_id)
                    ->max('order');
                $category->order = ($maxOrder ?? 0) + 1;
            }
        });

        // Atualiza slug ao modificar nome
        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        // Ao deletar, move produtos para categoria pai ou null
        static::deleting(function ($category) {
            $category->products()->update([
                'category_id' => $category->parent_id
            ]);

            // Move subcategorias para o pai da categoria deletada
            $category->children()->update([
                'parent_id' => $category->parent_id
            ]);
        });
    }

    /**
     * Relacionamentos
     */

    /**
     * Categoria pai (para subcategorias)
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Subcategorias (categorias filhas)
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->orderBy('order');
    }

    /**
     * Subcategorias recursivas (todos os níveis)
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    /**
     * Produtos da categoria
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Produtos ativos da categoria
     */
    public function activeProducts()
    {
        return $this->hasMany(Product::class)->where('active', true);
    }

    /**
     * Scopes
     */

    /**
     * Apenas categorias ativas
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Apenas categorias raiz (sem pai)
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Apenas subcategorias
     */
    public function scopeChild($query)
    {
        return $query->whereNotNull('parent_id');
    }

    /**
     * Ordenadas
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Busca por nome ou descrição
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    /**
     * Com contagem de produtos
     */
    public function scopeWithProductCount($query)
    {
        return $query->withCount(['products', 'activeProducts']);
    }

    /**
     * Acessores (Getters)
     */

    /**
     * Caminho completo da categoria (Categoria Pai > Subcategoria)
     */
    public function getFullPathAttribute()
    {
        $path = collect([$this->name]);
        $parent = $this->parent;

        while ($parent) {
            $path->prepend($parent->name);
            $parent = $parent->parent;
        }

        return $path->join(' > ');
    }

    /**
     * Nível da categoria (0 = raiz, 1 = primeira subcategoria, etc)
     */
    public function getLevelAttribute()
    {
        $level = 0;
        $parent = $this->parent;

        while ($parent) {
            $level++;
            $parent = $parent->parent;
        }

        return $level;
    }

    /**
     * Verifica se é categoria raiz
     */
    public function getIsRootAttribute()
    {
        return is_null($this->parent_id);
    }

    /**
     * Verifica se tem subcategorias
     */
    public function getHasChildrenAttribute()
    {
        return $this->children()->exists();
    }

    /**
     * URL da imagem
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/no-category-image.png');
    }

    /**
     * Cor hexadecimal ou padrão
     */
    public function getColorValueAttribute()
    {
        return $this->color ?? '#6B7280'; // gray-500 como padrão
    }

    /**
     * Métodos auxiliares
     */

    /**
     * Retorna todas as categorias filhas recursivamente
     */
    public function getAllDescendants()
    {
        $descendants = collect();

        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->getAllDescendants());
        }

        return $descendants;
    }

    /**
     * Retorna todos os ancestrais (pais) até a raiz
     */
    public function getAllAncestors()
    {
        $ancestors = collect();
        $parent = $this->parent;

        while ($parent) {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }

        return $ancestors;
    }

    /**
     * Toggle status ativo/inativo
     */
    public function toggleActive(): void
    {
        $this->update(['active' => !$this->active]);
    }

    /**
     * Reordena categorias
     */
    public static function reorder(array $order): void
    {
        foreach ($order as $index => $categoryId) {
            static::where('id', $categoryId)->update(['order' => $index]);
        }
    }

    /**
     * Move categoria para cima na ordem
     */
    public function moveUp(): bool
    {
        $previous = static::where('company_id', $this->company_id)
            ->where('parent_id', $this->parent_id)
            ->where('order', '<', $this->order)
            ->orderBy('order', 'desc')
            ->first();

        if ($previous) {
            $tempOrder = $this->order;
            $this->update(['order' => $previous->order]);
            $previous->update(['order' => $tempOrder]);
            return true;
        }

        return false;
    }

    /**
     * Move categoria para baixo na ordem
     */
    public function moveDown(): bool
    {
        $next = static::where('company_id', $this->company_id)
            ->where('parent_id', $this->parent_id)
            ->where('order', '>', $this->order)
            ->orderBy('order', 'asc')
            ->first();

        if ($next) {
            $tempOrder = $this->order;
            $this->update(['order' => $next->order]);
            $next->update(['order' => $tempOrder]);
            return true;
        }

        return false;
    }

    /**
     * Retorna categorias em árvore hierárquica
     */
    public static function tree()
    {
        return static::with('descendants')
            ->whereNull('parent_id')
            ->ordered()
            ->get();
    }

    /**
     * Retorna opções para select (formato: id => nome com indentação)
     */
    public static function selectOptions($indent = '—')
    {
        $categories = static::with('descendants')
            ->whereNull('parent_id')
            ->ordered()
            ->get();

        $options = collect();

        foreach ($categories as $category) {
            $options->put($category->id, $category->name);
            static::addChildrenToOptions($category->children, $options, $indent);
        }

        return $options;
    }

    /**
     * Adiciona filhos às opções recursivamente
     */
    private static function addChildrenToOptions($children, &$options, $indent, $level = 1)
    {
        foreach ($children as $child) {
            $prefix = str_repeat($indent, $level) . ' ';
            $options->put($child->id, $prefix . $child->name);

            if ($child->children->isNotEmpty()) {
                static::addChildrenToOptions($child->children, $options, $indent, $level + 1);
            }
        }
    }
}
