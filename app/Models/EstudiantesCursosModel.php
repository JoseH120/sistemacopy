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
            'IdEstudiante'=> 'required|numeric',
            'IdCurso'=> 'required|numeric'
        ];

        protected $validationMessages = [
            'IdEstudiante' => [
                'numeric' => 'Estimado usuario, debe ingresar un numero como ID '
            ],
            'IdCurso'=> [
                'numeric'=> 'Estimado usuario, debe ingresar un numero como ID '
            ]
        ];

        protected $skipValidation = false;
    }
?>