# Autorizacao-Granular-com-Gates-e-Policies_EXEMPLO_PROJETO
Autorização Granular com Gates e Policies
Sistema de autenticação nativo, checagem de
permissões e diretivas condicionais @can.

# Autorização com Gates e Policies (Laravel)

Exemplo simples de **login nativo**, **Gates**, **Policies** e **@can**.

## O básico

- **Auth**: descobre *quem* é o usuário (login)
- **Gate**: regra geral. Ex.: "só admin acessa o painel"
- **Policy**: regra de um Model. Ex.: "só o dono edita o post"
- **@can**: mostra/esconde coisas no Blade

## 1. Login (Auth nativo)

```php
// AuthController
public function login(Request $request)
{
    $credentials = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/dashboard');
    }

    return back()->withErrors(['email' => 'Dados inválidos.']);
}

public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
}
```

```php
// routes/web.php
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
```

Para proteger uma página só para logados, use o middleware `auth`.

## 2. Gate (regra geral)

Crie em `app/Providers/AppServiceProvider.php`, dentro do `boot()`:

```php
use Illuminate\Support\Facades\Gate;

Gate::define('access-admin', function (User $user) {
    return $user->role === 'admin';
});
```

## 3. Policy (regra de um Model)

```bash
php artisan make:policy PostPolicy --model=Post
```

```php
class PostPolicy
{
    // admin pode tudo
    public function before(User $user): ?bool
    {
        return $user->role === 'admin' ? true : null;
    }

    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id; // só o dono
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}
```

O Laravel encontra a Policy sozinho (`Post` -> `PostPolicy`).

## 4. Usando nas rotas e controllers (back-end)

**Na rota:**

```php
Route::get('/admin', fn () => view('admin'))->middleware('can:access-admin');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('can:update,post');
```

**No controller:**

```php
use Illuminate\Support\Facades\Gate;

public function update(Request $request, Post $post)
{
    Gate::authorize('update', $post); // dá 403 se não puder
    // ...
}
```

## 5. Usando no Blade (front-end)

```blade
@can('access-admin')
    <a href="/admin">Painel Admin</a>
@endcan

@can('update', $post)
    <a href="{{ route('posts.edit', $post) }}">Editar</a>
@endcan

@cannot('update', $post)
    <p>Sem permissão</p>
@endcannot
```

## Usuários de teste (senha: `12345678`)

| E-mail | Role | Pode |
|---|---|---|
| admin@teste.com | admin | Tudo |
| editor@teste.com | editor | Editar só os seus posts |
| user@teste.com | user | Só visualizar |

## Erros comuns

- **Proteger só o front e não o back**: esconder um botão com `@can` não impede ninguém de acessar a URL ou enviar a requisição direto. O Blade é só visual. A segurança de verdade tem que estar na rota (`middleware('can:...')`) e/ou no controller (`Gate::authorize()`). Use o `@can` para a experiência do usuário e o back-end para a proteção.
- **Sempre 403**: rode `php artisan optimize:clear` e confira o nome da Policy.
- **`authorize()` não existe**: no Laravel 11+ use `Gate::authorize()`.
- **Role não atualiza**: faça logout e login de novo.

## Docs

- https://laravel.com/docs/authentication
- https://laravel.com/docs/authorization
