<?php

namespace Database\Factories;

use App\Models\MovimentacaoEstoque;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovimentacaoEstoqueFactory extends Factory
{
    protected $model = MovimentacaoEstoque::class;

    public function definition(): array
    {
        return [
            'produto_id' => Produto::factory(),
            'user_id' => User::factory(),
            'tipo' => fake()->randomElement(['entrada', 'saida']),
            'quantidade' => fake()->numberBetween(1, 50),
            'motivo' => fake()->sentence(),
        ];
    }
}