<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\AlunoDaoInterface;
use App\Models\Aluno;
use Illuminate\Support\Collection;
use InvalidArgumentException;

final class AlunoService
{
    public function __construct(private AlunoDaoInterface $dao)
    {
    }

    public function listar(string $busca = ''): Collection
    {
        return $this->dao->listar(trim($busca));
    }

    public function obter(?int $id): ?Aluno
    {
        return $id ? $this->dao->buscarPorId($id) : null;
    }

    public function salvar(array $dados, ?int $id = null): Aluno
    {
        $nome = trim((string) ($dados['nome'] ?? ''));
        $email = trim((string) ($dados['email'] ?? ''));
        $cursoId = (int) ($dados['curso_id'] ?? 0);
        if ($nome === '' || mb_strlen($nome) < 3) {
            throw new InvalidArgumentException('Informe um nome com pelo menos 3 caracteres.');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Informe um e-mail válido.');
        }
        if ($cursoId < 1) {
            throw new InvalidArgumentException('Selecione um curso.');
        }
        $dataNascimento = trim((string) ($dados['data_nascimento'] ?? ''));
        return $this->dao->salvar(['nome' => $nome, 'email' => $email, 'curso_id' => $cursoId, 'data_nascimento' => $dataNascimento !== '' ? $dataNascimento : null], $id);
    }

    public function remover(int $id): bool
    {
        return $this->dao->remover($id);
    }
}
