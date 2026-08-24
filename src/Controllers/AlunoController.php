<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use App\Services\AlunoService;
use Throwable;

final class AlunoController
{
    public function __construct(
        private AlunoService $alunoService,
        private CursoController $cursoController,
    ) {
    }

    public function index(): void
    {
        $action = $_POST['action'] ?? $_GET['action'] ?? 'listar';
        $message = null;
        $error = null;
        $editingAluno = null;
        $alunos = collect();
        $cursos = collect();

        try {
            Database::boot();
            $this->handlePost($action);

            $editingAluno = $action === 'editar'
                ? $this->alunoService->obter((int) ($_GET['id'] ?? 0))
                : null;
            $alunos = $this->alunoService->listar((string) ($_GET['busca'] ?? ''));
            $cursos = $this->cursoController->listar();
            $message = $this->messageFromQuery();
        } catch (Throwable $exception) {
            $error = $exception instanceof \InvalidArgumentException || $exception instanceof \DomainException
                ? $exception->getMessage()
                : 'Não foi possível acessar o banco. Importe database/schema.sql e confira o arquivo .env.';
        }

        $this->render('alunos', compact('action', 'message', 'error', 'editingAluno', 'alunos', 'cursos'));
    }

    private function handlePost(string $action): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        if ($action === 'salvar_aluno') {
            $this->alunoService->salvar($_POST, !empty($_POST['id']) ? (int) $_POST['id'] : null);
            $this->redirect('?saved=aluno');
        }
        if ($action === 'excluir_aluno') {
            $this->alunoService->remover((int) $_POST['id']);
            $this->redirect('?deleted=aluno');
        }

        $this->cursoController->handlePost($action);
    }

    private function messageFromQuery(): ?string
    {
        return match ($_GET['saved'] ?? $_GET['deleted'] ?? '') {
            'aluno' => 'Aluno salvo com sucesso.',
            'curso' => 'Curso salvo com sucesso.',
            default => null,
        };
    }

    private function redirect(string $location): never
    {
        header('Location: ' . $location);
        exit;
    }

    private function render(string $view, array $data): void
    {
        extract($data, EXTR_SKIP);
        require dirname(__DIR__) . '/Views/' . $view . '.php';
    }
}
