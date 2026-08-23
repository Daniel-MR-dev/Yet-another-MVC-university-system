<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Aluno extends Model
{
    protected $table = 'alunos';
    protected $fillable = ['nome', 'email', 'curso_id', 'data_nascimento'];
    public $timestamps = true;

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
