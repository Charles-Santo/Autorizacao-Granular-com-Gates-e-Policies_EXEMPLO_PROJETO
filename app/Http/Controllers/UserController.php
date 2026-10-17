<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        // Apenas admins podem acessar
        Gate::authorize('gerenciar-usuarios');

        $users = User::all();
        return view('users.index', compact('users'));
    }
}