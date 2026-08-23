<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\CursoDaoInterface;
use App\Models\Curso;
use Illuminate\Support\Collection;
use InvalidArgumentException;

final class CursoService
{
    public function __construct(private CursoDaoInterface $dao)
    {
    }

    public function listar(): Collection
    {
        return $this->dao->listar();
    }

    public function salvar(array $dados, ?int $id = null): Curso
    {
        $nome = trim((string) ($dados['nome'] ?? ''));
        $turno = trim((string) ($dados['turno'] ?? ''));
        if ($nome === '' || $turno === '') {
            throw new InvalidArgumentException('Informe nome e turno do curso.');
        }
        return $this->dao->salvar(['nome' => $nome, 'turno' => $turno], $id);
    }

    public function remover(int $id): bool
    {
        return $this->dao->remover($id);
    }
}
