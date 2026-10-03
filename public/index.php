<?php

declare(strict_types=1);

use App\Controllers\AlunoController;
use App\Controllers\CursoController;
use App\Dao\AlunoDao;
use App\Dao\CursoDao;
use App\Services\AlunoService;
use App\Services\CursoService;

require dirname(__DIR__) . '/vendor/autoload.php';

$alunoService = new AlunoService(new AlunoDao());
$cursoController = new CursoController(new CursoService(new CursoDao()));

$controller = new AlunoController($alunoService, $cursoController);
$controller->index();
