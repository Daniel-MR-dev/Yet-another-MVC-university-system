<?php

declare(strict_types=1);

use App\Controllers\AlunoController;
use App\Controllers\CursoController;
use App\Dao\AlunoDao;
use App\Dao\CursoDao;
use App\Services\AlunoService;
use App\Services\CursoService;

require dirname(__DIR__) . '/vendor/autoload.php';

$controller = new AlunoController(
    new AlunoService(new AlunoDao()),
    new CursoController(new CursoService(new CursoDao())),
);

$controller->index();
