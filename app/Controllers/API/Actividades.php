<?php
    namespace App\Controllers\API;

    use App\Models\ActividadesModel;
    use CodeIgniter\RESTful\ResourceController;
    use Exception;

    class Actividades extends ResourceController
    {

        public function __construct()
        {
            $this->model = $this->setModel(new ActividadesModel());
        }
        //Listar 
        public function index(){
            $actividades = $this->model->findAll();
            return $this->respond($actividades);
        }

        //servicio de insertar
        public function create (){
            try{
                $actividades = $this->request->getJSON();
                if($this->model->insert($actividades)){
                    $actividades->IdActividad = $this->model->insertID();
                    return $this->respondCreated($actividades);
                }
                else{
                    return $this->failValidationError($this->model->validation->listErrors());
                }
            }
            catch(Exception $e){
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }

        //Servicio para buscar un registro
        public function edit($id = null){
            try {
                if($id == null){
                    return $this->failValidationErrors('No se ha enviado un id valido');
                }
                $actividad = $this->model->find($id);
                if($actividad == null){
                    return $this->failNotFound('No se ha encorntrado un registro con el ID: '.$id. ' enviado');
                }
                return $this->respond($actividad);
            } catch (Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor');
            }
        }

        //Servicio de actualizar un registro
        public function update($id = null){
            try {
                if($id == null){
                    return $this->failValidationError('No se ha enviado un id valido');
                }
                $actividadVerificado = $this->model->find($id);
                if($actividadVerificado == null){
                    return $this->failNotFound('No se ha encorntrado un registro con el ID: '.$id. ' enviado');
                }
                $actividad = $this->request->getJSON();

                if($this->model->update($id, $actividad)){
                    $actividad->IdActividad = $id;
                    return $this->respondUpdated($actividad);
                }
                else{
                    return $this->failValidationError($this->model->validation->listErrors());
                }
            } catch (Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor');
            }
        }

        //Servicio de eliminar un registro
        public function delete($id = null){
            try {
                if($id == null){
                    return $this->failValidationError('No se ha enviado un id valido');
                }
                $actividadVerificada = $this->model->find($id);
                if($actividadVerificada == null){
                    return $this->failNotFound('No se ha encorntrado un registro con el ID: '.$id. ' enviado');
                }
                
                if($this->model->delete($id)){
                    return $this->respondDeleted($actividadVerificada);
                }
                else{
                    return $this->failValidationError('No se ha podido eliminar el registro');
                }
            } catch (Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor');
            }
        }

        public function actividadesByCurso($idCurso){
            try {
                if($idCurso == null){
                    return $this->failValidationErrors('No se ha enviado un id valido');
                }
                $actividades = $this->model->getActividadesByCurso($idCurso);
                if($actividades == null){
                    return $this->failNotFound('No se ha encorntrado actividades con el ID CURSO: '.$id. ' enviado');
                }
                return $this->respond($actividades);
            } catch (Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor');
            }
        }
    }