<?php

namespace App\Models;

use CodeIgniter\Model;

class SeccionesModel extends Model{

    protected $table = 'secciones';
    protected $primaryKey = 'IdSeccion';

    protected $returnType = 'array';

    protected $allowedFields = ['Contenido', 'Url', 'IdLeccion'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'Contenido' => 'required|min_length[3]',
        'IdLeccion' => 'required|is_valid_leccion'
    ];

    protected $validationMessages = [
        'Contenido' => [
            'required' => 'El {field} es requerido',
            'min_length' => "El campo {field} debe tener almenos {value} catacteres"
        ],
        'IdLeccion' =>  [
            'required' => 'El {field} es requerido',
            'is_valid_leccion' => 'el id de leccion no existe'
        ]
    ];

    protected $skipValidation = false;
}