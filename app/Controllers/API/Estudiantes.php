<?php
    namespace App\Controllers\API;

    use App\Models\EstudiantesModel;
    use CodeIgniter\RESTful\ResourceController;
    

    class Estudiantes extends ResourceController
    {

        public function __construct()
        {
            $this->model = $this->setModel(new EstudiantesModel());
        }

        public function index()
        {
           $estudiantes = $this->model->findAll();
           return $this->respond($estudiantes);
        }
    }
?>