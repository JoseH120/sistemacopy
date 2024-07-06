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
        "NombreCurso" => 'required|min_length[3]|max_length[500]',
        "Descripcion" => 'required|min_length[3]|max_length[500]',
        "Grupo" => 'required|min_length[2]|max_length[50]',
        "IdTutor" => 'required|integer|is_valid_tutor'
    ];

    protected $validationMessages = [
        'NombreCurso' => [
            'required' => 'El valor es requerido',
            'min_length' => 'Debe ser mayor que 3 caracteres',
            'max_length' => 'Debe ser menor de 500 caracteres'
        ],
        'Descripcion' => [
            'required' => 'El valor es requerido',
            'min_length' => 'Debe ser mayor que 3 caracteres',
            'max_length' => 'Debe ser menor de 500 caracteres'
        ],
        'Grupo' => [
            'required' => 'El valor es requerido',
            'min_length' => 'Debe ser mayor que 2 caracteres',
            'max_length' => 'Debe ser menor de 50 caracteres'
        ],
        'IdTutor' => [
            'required' => 'El valor es requerido',
            'integer' => 'El valor debe ser entero',
            'is_valid_tutor' => 'Ingrese un id existente en la base de datos'
        ]
    ];

    protected $skipValidation = false;
}
