<?php

    namespace App\Controllers\Estudiantes;

    use App\Models\EstudianteModel;
    use CodeIgniter\RESTful\ResourceController;
    use Exception;

    class Estudiantes extends ResourceController{

        public function __construct()
        {
            $this->model = $this->setModel(new EstudianteModel());
        }

        public function index()
        {
            $estudiantes = $this->model->findAll();
            return $this->respond($estudiantes);
        }
    }
?>