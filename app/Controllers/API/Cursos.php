<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CursosModel;
use Exception;

class Cursos extends ResourceController
{

    public function __construct()
    {
        $this->model = $this->setModel(new CursosModel());
    }

    public function index()
    {
        $cursos = $this->model->findAll();
        return $this->respond($cursos);
    }

    public function create()
    {
        helper(['form']);

        $rules = [
            'NombreCurso' => 'required|alpha_space|min_length[3]|max_length[500]',
            'Descripcion' => 'required|alpha_space|min_length[3]|max_length[500]',
            'Grupo' => 'required|alpha_space|min_length[2]|max_length[500]',
            'IdTutor' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        } else {
            $data = [
                'NombreCurso' => $this->request->getVar('NombreCurso'),
                'Descripcion' => $this->request->getVar('Descripcion'),
                'Grupo' => $this->request->getVar('Grupo'),
                'IdTutor' => $this->request->getVar('IdTutor'),
            ];
            $IdCurso = $this->model->insert($data);
            $data['IdCurso'] = $IdCurso;
            return $this->respondCreated($data);
        }
        // try {
        //     $cursos = $this->request->getJSON();
        //     if ($this->model->insert($cursos)) {
        //         $cursos->IdCurso = $this->model->insertID();
        //         return $this->respondCreated($cursos);
        //     } else {
        //         return $this->failValidationError($this->model->listErrors());
        //     }
        // } catch (Exception $e) {
        //     return $this->failServerError('Ha ocurrido un error en el servidor.');
        // }
    }
}
