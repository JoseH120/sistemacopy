<?php

namespace App\Controllers\API;

use App\Models\UsuariosModel;
use CodeIgniter\RESTful\ResourceController;
use Exception;

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header('Access-Control-Allow-Headers: token, Content-Type');
        header('Access-Control-Max-Age: 1728000');
        header('Content-Length: 0');
        header('Content-Type: text/plain');
        die();
}
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

class Usuarios extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new UsuariosModel());
    }

    //Listar 
    public function index()
    {
        $usuarios = $this->model->findAll();
        return $this->respond($usuarios);
    }

    //Servicio de insertar
    public function create()
    {
        try {
            $usuario = $this->request->getJSON();
            if ($this->model->insert($usuario)) {
                $usuario->IdUsuario = $this->model->insertID();
                return $this->respondCreated($usuario);
            } else {
                return $this->failValidationError($this->model->validation->listErrors());
            }
        } catch (Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor." . $e->getMessage());
        }
    }


    //Servicio para obtener informacion de un usuario.
    public function edit($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationError('No se ha enviado un id valido.');
            }
            $usuario = $this->model->find($id);
            if ($usuario == null) {
                return $this->failNotFound("No se ha encontrado un registro con el id " . $id . " enviado");
            }
            return $this->respond($usuario);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationError("No se ha enviado un ID valido.");
            }
            $usuario = $this->model->find($id);
            if ($usuario == null) {
                return $this->failValidationError("No se ha encontrado un registro con el ID " . $id . " enviado");
            }
            $data = $this->request->getJSON();
            if ($this->model->update($id, $data)) {
                $data->IdUsuario = $id;
                return $this->respondUpdated($data);
            } else {
                return $this->failValidationError($this->model->validation->listErrors());
            }
        } catch (Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor.");;
        }
    }

    public function delete($id = null)
    {
        try {
            $data = $this->model->find($id);
            if ($data == null) {
                return $this->failNotFound("No se ha encontrado un registro con el ID " . $id . " enviado");
            }
            return $this->model->delete($id)  ? $this->respondDeleted($data) : $this->failValidationError("No se pudo eliminar el registro.");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUsuariosNoAsignados(){
        $usuarios = $this->model->usuariosNoAsignados();
        return $this->respond($usuarios);   
    }
}
