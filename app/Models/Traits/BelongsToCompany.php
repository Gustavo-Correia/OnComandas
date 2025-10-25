<?php

namespace App\Models\Traits;

use App\Models\Company;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
trait BelongsToCompany
{
    /**
     * Boot do trait - adiciona company_id automaticamente ao criar
     */
    protected static function bootBelongsToCompany()
    {
        static::creating(function ($model) {
            if (Auth::check() && ! $model->company_id) {
                $model->company_id = Auth::user()->company_id;
            }
        });
    }

    /**
     * Relacionamento com Company
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Scope para filtrar por empresa
     */
    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Scope para empresa do usuário autenticado
     */
    public function scopeForCurrentCompany($query)
    {
        if (Auth::check()) {
            return $query->where('company_id', Auth::user()->company_id);
        }
        
        return $query;
    }
}
