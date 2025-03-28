<?php

namespace App\Controllers\API;

use App\Models\SeccionesModel;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class Secciones extends ResourceController
{

    public function __construct()
    {
        $this->model = $this->setModel(new SeccionesModel());
    }

    public function index()
    {
        $secciones = $this->model->findAll();
        return $this->respond($secciones);
    }

    public function seccionesByLeccion($idLeccion)
    {
        $secciones = $this->model->where('IdLeccion', $idLeccion)->orderBy('created_at', 'asc')->findAll();
        return $this->respond($secciones);
    }

    //servicio de insertar
    public function create()
    {

        $Contenido = $this->request->getVar('Contenido');
        $IdLeccion = $this->request->getVar('IdLeccion');

        $secciones = array('Contenido' => $Contenido, 'IdLeccion' => $IdLeccion);

        if (isset($_FILES['file'])) {
            $nombre = $_FILES['file']['name'];
            $tipo = $_FILES['file']['type'];
            $size =  $_FILES['file']['size'];
            $temporal = $_FILES['file']['tmp_name'];

            //Contruccion de la url del archivo para almacenar en database
            $URLArchivo = "http://localhost/sistema/uploads/secciones/"
                . $IdLeccion . "/" . str_replace(" ", "", $nombre);

            $secciones['Url'] = $URLArchivo;
        }

        try {
            if ($this->model->insert($secciones)) {
                $secciones['IdSeccion'] = $this->model->insertID();

                if (isset($_FILES['file'])) {
                    if ($this->crear($temporal, str_replace(" ", "", $nombre), $IdLeccion)) {
                        //Respondemos exitosamente.
                        return $this->respondCreated($secciones);
                    }
                }

                return $this->respondCreated($secciones);
            } else {
                return $this->failValidationError($this->model->validation->listErrors());
            }
        } catch (Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor.' . $e->getMessage());
        }
    }

    //Servicio para buscar un registro
    public function edit($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationErrors('No se ha enviado un id valido');
            }
            $seccion = $this->model->find($id);
            if ($seccion == null) {
                return $this->failNotFound('No se ha encorntrado un registro con el ID: ' . $id . ' enviado');
            }
            return $this->respond($seccion);
        } catch (Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    //Servicio de actualizar un registro
    public function update($id = null)
    {
        if ($id == null) {
            return $this->failValidationError('No se ha enviado un id valido');
        }
        try {
            $seccionVerificada = $this->model->find($id);

            if ($seccionVerificada == null) {
                return $this->failNotFound('No se ha encorntrado un registro con el ID: ' . $id . ' enviado');
            }

            $Contenido = $this->request->getVar('Contenido');
            $IdLeccion = $this->request->getVar('IdLeccion');

            $secciones = array('Contenido' => $Contenido, 'IdLeccion' => $IdLeccion);

            if (isset($_FILES['file'])) {
                $nombre = $_FILES['file']['name'];
                $tipo = $_FILES['file']['type'];
                $size =  $_FILES['file']['size'];
                $temporal = $_FILES['file']['tmp_name'];

                $URLArchivo = "http://localhost/sistema/uploads/secciones/"
                    . $IdLeccion . "/" . str_replace(" ", "", $nombre);

                if ($seccionVerificada['Url'] != null) {

                    $file = substr($seccionVerificada['Url'], 25, strlen($seccionVerificada['Url']));

                    if ($this->eliminar($file)) {
                        if ($this->crear(
                            $temporal,
                            str_replace(" ", "", $nombre),
                            $IdLeccion
                        )) {
                            $secciones['Url'] = $URLArchivo;
                        }
                    }
                } else {
                    if ($this->crear(
                        $temporal,
                        str_replace(" ", "", $nombre),
                        $IdLeccion
                    )) {
                        $secciones['Url'] = $URLArchivo;
                    }
                }
            }

            if ($this->model->update($id, $secciones)) {
                $secciones['IdSeccion'] = $id;
                return $this->respondUpdated($secciones);
            } else {
                return $this->failValidationError($this->model->validation->listErrors());
            }
        } catch (Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    public function delete($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationError('No se ha enviado un id valido');
            }

            $seccionVerificada = $this->model->find($id);

            if ($seccionVerificada == null) {
                return $this->failNotFound('No se ha encorntrado un registro con el ID: ' . $id . ' enviado');
            }

            if ($this->model->delete($id)) {

                if ($seccionVerificada['Url'] != null) {

                    $file = substr($seccionVerificada['Url'], 25, strlen($seccionVerificada['Url']));

                    if ($this->eliminar($file)) {
                        return $this->respondDeleted($seccionVerificada);
                    }
                }
                return $this->respondDeleted($seccionVerificada);
            } else {
                return $this->failValidationError('No se ha podido eliminar el registro');
            }
        } catch (Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor ' . $e);
        }
    }

    private function crear($temporal, $nombre, $IdLeccion)
    {
        $pathRelativa = 'uploads/secciones/' . $IdLeccion;
        if (!file_exists($pathRelativa)) {
            mkdir($pathRelativa, 0777, true);
            if (file_exists($pathRelativa)) {
                if (move_uploaded_file($temporal, $pathRelativa . '/' . $nombre)) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            if (move_uploaded_file($temporal, $pathRelativa . '/' . $nombre)) {
                return true;
            } else {
                return false;
            }
        }
    }

    private function eliminar($file)
    {

        if (unlink($file)) {
            return true;
        } else {
            return false;
        }
    }
}
