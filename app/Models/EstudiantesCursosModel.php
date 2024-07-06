<?php
    namespace App\Models;

    use CodeIgniter\Model;

    class EstudiantesCursosModel extends Model{

        protected $table = 'estudiantes_cursos';
        protected $primaryKey = 'Idestudiante_curso';
        protected $returnType = 'array';
        protected $allowedFields = ['IdEstudiante','IdCurso'];

        protected $useTimestamps = true;
        protected $createdField = 'created_at';
        protected $updatedField = 'updated_at'; 
        
        protected $validationRules = [
            'IdEstudiante'=> 'required|numeric|is_valid_estudiante',
            'IdCurso'=> 'required|numeric|is_valid_curso'
        ];

        protected $validationMessages = [
            'IdEstudiante' => [
                'required' => 'El valor es requerido',
                'numeric' => 'Estimado usuario, debe ingresar un numero como ID ',
                'is_valid_estudiante' => 'el id estudiante no existe'
            ],
            'IdCurso'=> [
                'required' => 'El valor es requerido',
                'numeric'=> 'Estimado usuario, debe ingresar un numero como ID ',
                'is_valid_curso' => 'el id curso no existe'
            ]
        ];

        protected $skipValidation = false;
    }
