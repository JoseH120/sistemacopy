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
    protected $skipValidation = false;


    protected $validationRules = [
        "NombreCurso" => 'required',
        "Descripcion" => 'required',
        "Grupo" => 'required',
        "IdTutor" => 'required'
    ];
}
