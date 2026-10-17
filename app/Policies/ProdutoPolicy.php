<?php

namespace App\Policies;

use App\Models\Produto;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProdutoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Todos os papéis cadastrados podem listar os produtos
        return in_array($user->role, ['operador', 'gerente', 'admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Produto $produto): bool
    {
        // Todos podem visualizar os detalhes de um produto
        return in_array($user->role, ['operador', 'gerente', 'admin']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Apenas gerentes e administradores podem cadastrar novos produtos
        return in_array($user->role, ['gerente', 'admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Produto $produto): bool
    {
        // Apenas gerentes e administradores podem editar produtos
        return in_array($user->role, ['gerente', 'admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Produto $produto): bool
    {
        // Apenas o administrador supremo (admin) pode excluir produtos
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Produto $produto): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Produto $produto): bool
    {
        return $user->role === 'admin';
    }
}