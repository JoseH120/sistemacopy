<?php

    namespace App\Models;

    use CodeIgniter\Model;

    class EstudiantesModel extends Model{
        
        protected $table = 'estudiantes';
        protected $primaryKey = 'IdEstudiante';

        protected $returnType = 'array';
        protected $allowedFields = ['PrimerNombre', 'SegundoNombre', 'PrimerApellido', 'SegundoApellido', 'Dui', 
                                    'Direccion', 'FechaNacimiento', 'Responsable', 'Correo', 'VacunaCovid', 'IdUsuario'];

        protected $useTimestamps = true;
        protected $createdField = 'created_at';
        protected $updatedField = 'updated_at';

        
        protected $validationRules = [
            'PrimerNombre' => 'required|alpha_space|min_length[3]|max_length[500]',
            'SegundoNombre' => 'required|alpha_space|min_length[3]|max_length[500]',
            'PrimerApellido' => 'required|alpha_space|min_length[3]|max_length[500]',
            'SegundoApellido' => 'required|alpha_space|min_length[3]|max_length[500]',
            'Dui' => 'exact_length[10]',
            'Direccion' => 'required|alpha_space|min_length[3]|max_length[500]', 
            'FechaNacimiento' => 'required|valid_date[YYYY/mm/dd]',
            'Responsable' => 'alpha_space|min_length[3]|max_length[500]',
            'Correo' => 'valid_email',
            'VacunaCovid' => 'required|numeric|less_than[3]|greater_than[0]',
            'IdUsuario' => 'required|numeric'
        ];

        protected $validationMessages = [
            'Edad' => [
                'numeric' => 'Ingrese un valor numerico',
                'less_than' => 'Ingresar una cantidad menor a 100',
                'greater_than' => 'Ingrese una cantidad mayor a 0'
            ]
        ];

        protected $skipValidation = false;
    }
?>