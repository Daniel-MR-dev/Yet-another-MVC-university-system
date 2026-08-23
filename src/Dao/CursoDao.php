<?php

declare(strict_types=1);

namespace App\Dao;

use App\Contracts\CursoDaoInterface;
use App\Models\Curso;
use Illuminate\Support\Collection;

final class CursoDao implements CursoDaoInterface
{
    public function listar(): Collection
    {
        return Curso::withCount('alunos')->orderBy('nome')->get();
    }

    public function buscarPorId(int $id): ?Curso
    {
        return Curso::find($id);
    }

    public function salvar(array $dados, ?int $id = null): Curso
    {
        $curso = $id === null ? new Curso() : Curso::findOrFail($id);
        $curso->fill($dados);
        $curso->save();
        return $curso;
    }

    public function remover(int $id): bool
    {
        $curso = Curso::findOrFail($id);
        if ($curso->alunos()->exists()) {
            throw new \DomainException('Não é possível excluir um curso que possui alunos.');
        }
        return (bool) $curso->delete();
    }
}
