<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Produto;
use App\Policies\ProdutoPolicy;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Registra a Policy do Produto (para as ações do ProdutoController)
        Gate::policy(Produto::class, ProdutoPolicy::class);

        // 2. Define o Gate para gerenciar usuários (Exclusivo para Admin)
        Gate::define('gerenciar-usuarios', function (User $user) {
            return $user->role === 'admin';
        });

        // 3. Define o Gate para movimentar o estoque (Operador, Gerente e Admin)
        Gate::define('fazer-movimentacao', function (User $user) {
            return in_array($user->role, ['operador', 'gerente', 'admin']);
        });
    }
}