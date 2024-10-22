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
                'required' => 'El valor "Id estudiante" es requerido',
                'numeric' => 'Estimado usuario, debe ingresar un numero como ID ',
                'is_valid_estudiante' => 'el id estudiante no existe'
            ],
            'IdCurso'=> [
                'required' => 'El valor "Id Curso" es requerido',
                'numeric'=> 'Estimado usuario, debe ingresar un numero como ID ',
                'is_valid_curso' => 'el id curso no existe'
            ]
        ];

        protected $skipValidation = false;

        public function cursosByEstudiante($id = null){
            if($id == null){
                return null;
            }

            $builder = $this->db->table($this->table.' ec');

            $builder->select('ec.IdCurso, c.NombreCurso, t.IdTutor, CONCAT(t.Nombre, " ", T.Apellido) Nombre, c.Descripcion, c.Grupo');
            
            $builder->join('estudiantes e', 'ec.IdEstudiante = e.IdEstudiante');
            $builder->join('cursos c', 'ec.IdCurso = c.IdCurso ');
            $builder->join('tutores t', 't.IdTutor = c.IdTutor ');
            
            $builder->where('e.IdEstudiante', $id);

            $query = $builder->get();

            return $query->getResult();
        }

        public function listByCourse($idCurso = null){        
            if($idCurso == null){
                return null;
            }
            $builder = $this->db->table($this->table.' ec');
            $builder->select('ec.Idestudiante_curso, e.IdEstudiante, CONCAT(e.PrimerNombre, " ", e.SegundoNombre) Nombre');
            $builder->select('CONCAT(e.PrimerApellido, " ", e.SegundoApellido) Apellido');
            $builder->select('e.Correo');

            $builder->join('estudiantes e', 'e.IdEstudiante = ec.IdEstudiante');

            $builder->where('ec.IdCurso',$idCurso);
            
            $query = $builder->get();

            return $query->getResult();
        }
    }
