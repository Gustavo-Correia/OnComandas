<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'phone',
    ];

    /**
     * Relacionamento: Uma empresa tem muitos usuários
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relacionamento: Uma empresa tem muitos pedidos
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relacionamento: Uma empresa tem muitos produtos
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Adicione mais relacionamentos conforme suas necessidades
}
