<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id', // ADICIONAR
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $dates = ['deleted_at'];

    /**
     * Relacionamento: Usuário pertence a uma empresa
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Verifica se o usuário pertence a uma empresa específica
     */
    public function belongsToCompany(int $companyId): bool
    {
        return $this->company_id === $companyId;
    }

    /**
     * Verifica se é administrador da empresa (implementar lógica conforme necessidade)
     */
    public function isCompanyAdmin(): bool
    {
        return $this->role === 'admin'; // Adicionar campo 'role' se necessário
    }
}
