<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Curso;
use Illuminate\Support\Collection;

interface CursoDaoInterface
{
    public function listar(): Collection;
    public function buscarPorId(int $id): ?Curso;
    public function salvar(array $dados, ?int $id = null): Curso;
    public function remover(int $id): bool;
}
