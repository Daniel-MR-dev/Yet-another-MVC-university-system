<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Aluno;
use Illuminate\Support\Collection;

interface AlunoDaoInterface
{
    public function listar(string $busca = ''): Collection;
    public function buscarPorId(int $id): ?Aluno;
    public function salvar(array $dados, ?int $id = null): Aluno;
    public function remover(int $id): bool;
}
