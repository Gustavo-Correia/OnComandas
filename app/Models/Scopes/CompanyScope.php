<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
class CompanyScope implements Scope
{
    /**
     * Aplica o scope automaticamente em TODAS as queries
     */
    public function apply(Builder $builder, Model $model)
    {
        if (Auth::check() && Auth::user()->company_id) {
            $builder->where('company_id', Auth::user()->company_id);
        }
    }

    /**
     * Permite desabilitar o scope quando necessário
     */
    public function extend(Builder $builder)
    {
        $builder->macro('withoutCompanyScope', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }
}
