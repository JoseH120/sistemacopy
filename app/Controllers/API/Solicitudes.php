<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\SolicitudesModel;
use Exception; 

class Solicitudes extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new SolicitudesModel());
    }

    public function index()
    {
        $solicitudes = $this->model->findAll();
        return $this->respond($solicitudes);
    }

    //Servicio para crear un registro
    public function create()
    {

        try {
            $solicitudes = $this->request->getJSON();
            if ($this->model->insert($solicitudes)) {
                $solicitudes->IdSolicitud = $this->model->insertID();
                return $this->respondCreated($solicitudes);
            } else {
                return $this->failValidationError($this->model->validation->listErrors());
            }
        } catch (Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor.');
        }
    }

    //Servicio para buscar un registro.
    public function edit($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationError('No se ha enviado un ID valido.');
            }
            $solicitud = $this->model->find($id);
            return $solicitud == null ?
                $this->failNotFound("No se ha encontrado un registro con el ID: " . $id . " enviado.") :
                $this->respond($solicitud);
        } catch (Exception $e) {
            return $this->failServerError("Ha ocurrido un error en la peticion.");
        }
    }

    //Servicio de actualizar un registro
    public function update($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationError("No se ha enviado un ID valido.");
            }
            $solicitud = $this->model->find($id);
            if ($solicitud == null) {
                return $this->failNotFound("No se ha encontrado un registro con el ID: " . $id . " enviado.");
            }

            $data = $this->request->getJSON();
            if ($this->model->update($id, $data)) {
                $data->IdSolicitud = $id;
                return $this->respondUpdated($data);
            } else {
                return $this->failValidationError($this->model->validation->listErrors());
            }
        } catch (Exception $e) {
            return $this->failServerError("Ha ocurrido un error en la peticion.");
        }
    }

    //Servicio para elimnar un registro
    public function delete($id = null)
    {
        try {
            $data = $this->model->find($id);
            if ($data == null) {
                return $this->failNotFound("No se ha encontrado un registro con el ID" . $id . " enviado.");
            }

            return $this->model->delete($id) ? $this->respondDeleted($data) : $this->failValidationError("No se ha podido eliminar el registro.");
        } catch (Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor.");
        }
    }

    
}

?>