<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Curso extends Model
{
    protected $table = 'cursos';
    protected $fillable = ['nome', 'turno'];
    public $timestamps = true;

    public function alunos(): HasMany
    {
        return $this->hasMany(Aluno::class);
    }
}
