<?php

declare(strict_types=1);

namespace App\Dao;

use App\Contracts\AlunoDaoInterface;
use App\Models\Aluno;
use Illuminate\Support\Collection;

final class AlunoDao implements AlunoDaoInterface
{
    public function listar(string $busca = ''): Collection
    {
        return Aluno::with('curso')
            ->when($busca !== '', fn ($query) => $query->where(function ($query) use ($busca) {
                $query->where('nome', 'like', "%{$busca}%")
                    ->orWhere('email', 'like', "%{$busca}%");
            }))
            ->orderBy('nome')
            ->get();
    }

    public function buscarPorId(int $id): ?Aluno
    {
        return Aluno::find($id);
    }

    public function salvar(array $dados, ?int $id = null): Aluno
    {
        $aluno = $id === null ? new Aluno() : Aluno::findOrFail($id);
        $aluno->fill($dados);
        $aluno->save();
        return $aluno;
    }

    public function remover(int $id): bool
    {
        return (bool) Aluno::findOrFail($id)->delete();
    }
}
