<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\CursoService;
use Illuminate\Support\Collection;

final class CursoController
{
    public function __construct(private CursoService $cursoService)
    {
    }

    public function listar(): Collection
    {
        return $this->cursoService->listar();
    }

    public function handlePost(string $action): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        if ($action === 'salvar_curso') {
            $this->cursoService->salvar($_POST);
            $this->redirect('?saved=curso');
        }
        if ($action === 'excluir_curso') {
            $this->cursoService->remover((int) $_POST['id']);
            $this->redirect('?deleted=curso');
        }
    }

    private function redirect(string $location): never
    {
        header('Location: ' . $location);
        exit;
    }
}
