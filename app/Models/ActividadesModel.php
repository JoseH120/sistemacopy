<?php

namespace App\Models;

use CodeIgniter\Model;

class ActividadesModel extends Model
{
    protected $table = 'actividades';

    protected $primaryKey = 'IdActividad';

    protected $returnType = 'array';

    protected $allowedFields = ['Tema', 'Descripcion', 'UrlRecurso', 'IdCurso'];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'Tema' => 'required|min_length[3]|max_length[500]',
        'Descripcion' => 'required|min_length[3]|max_length[500]',
        'UrlRecurso' => 'required|min_length[3]|max_length[600]',
        'IdCurso' => 'required|numeric'
    ];

    protected $validationMessages = [
        'UrlRecurso' => [
            'min_length' => 'Ingresar una cadena de texto mayor a 3 caracteres',
            'max_length' => 'Ingrese una cadena de texto menor a 600 caracteres'
        ],

        'IdCurso'=> [
            'numeric'=> 'Estimado usuario, debe ingresar un numero como ID '
        ]
    ];

    protected $skipValidation = true;
}