<?php
    namespace App\Controllers\API;

    use App\Models\TutoresModel;
    use CodeIgniter\RESTful\ResourceController;

    class Tutores extends ResourceController{

        public function __construct()
        {
            $this->model = $this->setModel(new TutoresModel());
        }

        public function index(){
            $tutores = $this->model->findAll();
            return $this->respond($tutores);
        }
    }
?>