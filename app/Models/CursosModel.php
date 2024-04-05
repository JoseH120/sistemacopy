<?php

namespace App\Models;

use CodeIgniter\Model;

class CursosModel extends Model
{
    protected $table = 'cursos';
    // protected $primaryKey = 'IdCurso';

    // protected $returnType = 'array';
    protected $allowedFields = ['IdCurso', 'NombreCurso', 'Descripcion', 'Grupo', 'IdTutor'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // protected $validationRules = [
    //     'NombreCurso' => 'required|alpha_space|min_length[3]|max_length[500]',
    //     'Descripcion' => 'required|alpha_space|min_length[3]|max_length[500]',
    //     'Grupo' => 'required|alpha_space|min_length[2]|max_length[500]',
    //     'IdTutor' => 'required',
    // ];

    protected $skipValidation = false;
}
