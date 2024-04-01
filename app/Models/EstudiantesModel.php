<?php
    namespace App\Models;
    use CodeIgniter\Model;

    class EstudianteModel extends Model{
        
        protected $table = 'estudiantes';
        protected $primaryKey = 'IdEstudiante';

        protected $returnType = 'array';
        protected $allowedFields = ['PrimerNombre', 'SegundoNombre', 'PrimerApellido', 'SegundoApellido', 'Edad'];

        protected $useTimestamps = false;
        
        protected $validationRules = [
            'PrimerNombre' => 'required|alpha_space|min_length[3]|max_length[500]',
            'SegundoNombre' => 'required|alpha_space|min_length[3]|max_length[500]',
            'PrimerApellido' => 'required|alpha_space|min_length[3]|max_length[500]',
            'SegundoApellido' => 'required|alpha_space|min_length[3]|max_length[500]',
            'Edad' => 'required|numeric|less_than[100]|greater_than[0]'
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