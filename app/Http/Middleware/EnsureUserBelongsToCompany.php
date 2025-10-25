<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class EnsureUserBelongsToCompany
{
    /**
     * Garante que o usuário só acesse dados da própria empresa
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Se não tem company_id, bloquear acesso
            if (! $user->company_id) {
                abort(403, 'Usuário não está associado a nenhuma empresa.');
            }

            // Disponibilizar company_id globalmente
            config(['app.current_company_id' => $user->company_id]);
        }

        return $next($request);
    }
}
