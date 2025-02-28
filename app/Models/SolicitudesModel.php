<?php
namespace App\Models;

use CodeIgniter\Model;

class SolicitudesModel extends Model{

    protected $table = 'solicitudes';
    protected $primaryKey = 'IdSolicitud';

    protected $returnType = 'array';
    protected $allowedFields = ['NombreCurso', 'Comentario', 'Estado', 'IdTutor'];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        "NombreCurso" => 'required|min_length[3]|max_length[500]',
        "Comentario" => 'permit_empty|min_length[3]|max_length[500]',
        "Estado" => 'required',
        "IdTutor" => 'required|integer|is_valid_tutor'
    ];

    protected $validationMessages = [
        'NombreCurso' => [
            'required' => 'El valor "nombre del curso" es requerido',
            'min_length' => '"Nombre del curso" debe ser mayor que 3 caracteres',
            'max_length' => '"Nombre del curso" debe ser menor de 500 caracteres'
        ],
        'Comentario' => [
            'required' => 'El valor "comentario" es requerido',
            'min_length' => '"comentario" debe ser mayor que 3 caracteres',
            'max_length' => '"comentario" debe ser menor de 500 caracteres'
        ],
        'Estado' => [
            'required' => 'El valor "grupo" es requerido'
        ],
        'IdTutor' => [
            'required' => 'El valor "ID Tutor" es requerido',
            'integer' => 'El valor "ID Tutor" debe ser entero',
            'is_valid_tutor' => 'Ingrese un ID tutor existente en la base de datos'
        ]
    ];

    protected $skipValidation = false;
}

?>