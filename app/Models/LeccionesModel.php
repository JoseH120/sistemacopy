<?php

namespace App\Models;

use CodeIgniter\Model;

class LeccionesModel extends Model{

    protected $table = 'lecciones';
    protected $primaryKey = 'IdLeccion';

    protected $returnType = 'array';

    protected $allowedFields = ['Tema', 'Descripcion', 'Url', 'FechaPublicacion', 'IdCurso'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'Tema' => 'required|min_length[3]|max_length[500]',
        'Descripcion' => 'permit_empty',
        'Url' => 'permit_empty|max_length[600]',
        'FechaPublicacion' => 'required',
        'IdCurso' => 'required|is_valid_curso'
    ];

    protected $validationMessages = [
        'Tema' => [
            'required' => 'El {field} es requerido',
            'min_length' => "El campo {field} debe tener almenos {value} catacteres",
            'max_length' => "El campo {field} debe tener menos de {value} catacteres"
        ],
        'FechaPublicacion' =>  [
            'required' => 'El {field} es requerido',
        ]
    ];

    protected $skipValidation = false;
}