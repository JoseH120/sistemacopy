<?php

    namespace App\Models;

    use CodeIgniter\Model;

    class EstudiantesModel extends Model{
        
        protected $table = 'estudiantes';
        protected $primaryKey = 'IdEstudiante';

        protected $returnType = 'array';
        protected $allowedFields = ['PrimerNombre', 'SegundoNombre', 'PrimerApellido', 'SegundoApellido', 'Dui', 
                                    'Direccion', 'FechaNacimiento', 'Responsable', 'Correo', 
                                    'VacunaCovid', 'IdUsuario'];

        protected $useTimestamps = true;
        protected $createdField = 'created_at';
        protected $updatedField = 'updated_at';

        protected $validationRules = [
            'PrimerNombre' => 'required|alpha|min_length[3]|max_length[500]',
            'SegundoNombre' => 'required|alpha|min_length[3]|max_length[500]',
            'PrimerApellido' => 'required|alpha|min_length[3]|max_length[500]',
            'SegundoApellido' => 'required|alpha|min_length[3]|max_length[500]',
            'Dui' => 'permit_empty|exact_length[9,10]',
            'Direccion' => 'required|alpha_dash|min_length[3]|max_length[500]',
            'FechaNacimiento' => 'required|valid_date',
            'Responsable' => 'permit_empty|alpha_space|min_length[3]|max_length[500]',
            'Correo' => 'permit_empty|valid_email',
            'VacunaCovid' => 'required|numeric|greater_than[0]|less_than[3]',
            'IdUsuario' => 'required|numeric'
        ];

        protected $validationMessages = [
            'Dui' => [
                'exact_length' => 'Debe tener entre 9 a 10 caracteres para ser aceptado'
            ],
            'FechaNacimiento' => [
                'valid_date' => 'La fecha es invalida',
            ],
            'Correo' => [
                'valid_email' => 'Estimado usuario, debe ingresar un email valido'
            ]
        ];

        protected $skipValidation = false;
    }
?>