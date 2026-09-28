<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MovimentacaoEstoque;

class MovimentacaoEstoqueSeeder extends Seeder
{
    public function run(): void
    {
        MovimentacaoEstoque::factory(20)->create();
    }
}