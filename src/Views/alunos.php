<?php

declare(strict_types=1);

function escapeHtml(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function formatDate(?string $date): string
{
    return $date ? date('d/m/Y', strtotime($date)) : '-';
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestão Acadêmica</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topbar"><div class="brand"><span class="brand-mark">GA</span><span>Gestão Acadêmica</span></div><span class="status">Painel administrativo</span></header>
<main class="shell">
    <section class="intro"><div><p class="eyebrow">CENTRO DE OPERAÇÕES</p><h1>Alunos</h1><p class="subtitle">Cadastre, acompanhe e organize a comunidade acadêmica.</p></div><div class="stats"><strong><?= count($alunos) ?></strong><span>alunos encontrados</span></div></section>
    <?php if ($message): ?><div class="notice success"><?= escapeHtml($message) ?></div><?php endif; ?>
    <?php if ($error): ?><div class="notice error"><?= escapeHtml($error) ?></div><?php endif; ?>
    <div class="layout">
        <section class="panel students-panel">
            <div class="panel-heading"><div><p class="eyebrow">DIRETÓRIO</p><h2>Cadastro de alunos</h2></div><a class="button primary" href="?action=novo">+ Novo aluno</a></div>
            <form class="search" method="get"><input name="busca" value="<?= escapeHtml($_GET['busca'] ?? '') ?>" placeholder="Buscar por nome ou e-mail"><button class="button secondary" type="submit">Buscar</button></form>
            <div class="table-wrap"><table><thead><tr><th>Aluno</th><th>Curso</th><th>Nascimento</th><th></th></tr></thead><tbody>
            <?php foreach ($alunos as $aluno): ?><tr><td><strong><?= escapeHtml($aluno->nome) ?></strong><small><?= escapeHtml($aluno->email) ?></small></td><td><?= escapeHtml($aluno->curso?->nome) ?></td><td><?= formatDate($aluno->data_nascimento) ?></td><td class="actions"><a href="?action=editar&id=<?= $aluno->id ?>">Editar</a><form method="post" onsubmit="return confirm('Excluir este aluno?')"><input type="hidden" name="action" value="excluir_aluno"><input type="hidden" name="id" value="<?= $aluno->id ?>"><button type="submit" class="danger-link">Excluir</button></form></td></tr><?php endforeach; ?>
            <?php if (count($alunos) === 0): ?><tr><td colspan="4" class="empty">Nenhum aluno encontrado.</td></tr><?php endif; ?></tbody></table></div>
        </section>
        <aside class="panel form-panel"><p class="eyebrow"><?= $editingAluno ? 'EDIÇÃO' : 'NOVO REGISTRO' ?></p><h2><?= $editingAluno ? 'Editar aluno' : 'Adicionar aluno' ?></h2><form method="post"><input type="hidden" name="action" value="salvar_aluno"><input type="hidden" name="id" value="<?= $editingAluno?->id ?? '' ?>"><label>Nome completo<input required name="nome" value="<?= escapeHtml($editingAluno?->nome) ?>"></label><label>E-mail institucional<input required type="email" name="email" value="<?= escapeHtml($editingAluno?->email) ?>"></label><label>Data de nascimento<input type="date" name="data_nascimento" value="<?= escapeHtml($editingAluno?->data_nascimento) ?>"></label><label>Curso<select required name="curso_id"><option value="">Selecione</option><?php foreach ($cursos as $curso): ?><option value="<?= $curso->id ?>" <?= ($editingAluno?->curso_id === $curso->id) ? 'selected' : '' ?>><?= escapeHtml($curso->nome) ?></option><?php endforeach; ?></select></label><button class="button primary full" type="submit">Salvar aluno</button><?php if ($editingAluno): ?><a class="cancel" href="/">Cancelar edição</a><?php endif; ?></form></aside>
    </div>
    <section class="panel courses"><div class="panel-heading"><div><p class="eyebrow">OUTRA ÁREA DE NEGÓCIO</p><h2>Cursos e turnos</h2></div><span class="tag">Catálogo acadêmico</span></div><div class="course-grid"><?php foreach ($cursos as $curso): ?><article class="course"><div><h3><?= escapeHtml($curso->nome) ?></h3><span><?= escapeHtml($curso->turno) ?></span></div><strong><?= $curso->alunos_count ?> <small>alunos</small></strong><form method="post"><input type="hidden" name="action" value="excluir_curso"><input type="hidden" name="id" value="<?= $curso->id ?>"><button class="icon-delete" title="Excluir curso" type="submit" onclick="return confirm('Excluir este curso?')">×</button></form></article><?php endforeach; ?></div><form class="inline-form" method="post"><input type="hidden" name="action" value="salvar_curso"><input required name="nome" placeholder="Nome do novo curso"><select required name="turno"><option value="">Turno</option><option>Matutino</option><option>Vespertino</option><option>Noturno</option></select><button class="button secondary" type="submit">Adicionar curso</button></form></section>
</main><footer>PHP 8.2 · Eloquent ORM · Arquitetura MVC</footer>
</body></html>
