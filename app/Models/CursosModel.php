<?php

namespace App\Models;

use CodeIgniter\Model;

class CursosModel extends Model
{
    protected $table = 'cursos';
    protected $primaryKey = 'IdCurso';

    protected $returnType = 'array';
    protected $allowedFields = ['NombreCurso', 'Descripcion', 'Grupo', 'IdTutor'];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        "NombreCurso" => 'required',
        "Descripcion" => 'required',
        "Grupo" => 'required',
        "IdTutor" => 'required|integer|is_valid_tutor'
    ];

    protected $validationMessages = [
        'IdTutor' => [
            'is_valid_tutor' => 'Ingrese un id existente en la base de datos'
        ]
    ];

    protected $skipValidation = false;
}
