<?php
    namespace App\Controllers\API;

    use App\Models\TutoresModel;
    use CodeIgniter\RESTful\ResourceController;
    use Exception;

    class Tutores extends ResourceController{

        public function __construct()
        {
            $this->model = $this->setModel(new TutoresModel());
        }
        //Listar 
        public function index(){
            $tutores = $this->model->findAll();
            return $this->respond($tutores);
        }

        //servicio de insertar
        public function create (){
            try{
                $tutores = $this->request->getJSON();
                if($this->model->insert($tutores)){
                    $tutores->IdTutor = $this->model->insertID();
                    return $this->respondCreated($tutores);
                }
                else{
                    return $this->failValidationError($this->model->listErrors());
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
                    return $this->failValidationError('No se ha enviado un id valido');
                }
                $tutor = $this->model->find($id);
                if($tutor == null){
                    return $this->failNotFound('No se ha encorntrado un registro con el ID: '.$id. ' enviado');
                }
                return $this->respond($tutor);
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
                $tutorVerificado = $this->model->find($id);
                if($tutorVerificado == null){
                    return $this->failNotFound('No se ha encorntrado un registro con el ID: '.$id. ' enviado');
                }
                $tutor = $this->request->getJSON();

                if($this->model->update($id, $tutor)){
                    $tutor->IdTutor = $id;
                    return $this->respondUpdated($tutor);
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
                $tutorVerificado = $this->model->find($id);
                if($tutorVerificado == null){
                    return $this->failNotFound('No se ha encorntrado un registro con el ID: '.$id. ' enviado');
                }
                
                if($this->model->delete($id)){
                    return $this->respondDeleted($tutorVerificado);
                }
                else{
                    return $this->failValidationError('No se ha podido eliminar el registro');
                }
            } catch (Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor');
            }
        }
    }
?>