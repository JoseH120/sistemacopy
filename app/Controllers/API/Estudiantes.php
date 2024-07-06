<?php
    namespace App\Controllers\API;

    use App\Models\EstudiantesModel;
    use CodeIgniter\RESTful\ResourceController;
    use Exception;

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

        //servicio de insertar
        public function create (){
            try{
                $estudiante = $this->request->getJSON();
                if($this->model->insert($estudiante)){
                    $estudiante->IdEstudiante = $this->model->insertID();
                    return $this->respondCreated($estudiante);
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
                    return $this->failValidationError('No se ha enviado un id valido');
                }
                $estudiante = $this->model->find($id);
                if($estudiante == null){
                    return $this->failNotFound('No se ha encorntrado un registro con el ID: '.$id. ' enviado');
                }
                return $this->respond($estudiante);
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
                $estudianteVerificado = $this->model->find($id);
                if($estudianteVerificado == null){
                    return $this->failNotFound('No se ha encorntrado un registro con el ID: '.$id. ' enviado');
                }
                $estudiante = $this->request->getJSON();

                if($this->model->update($id, $estudiante)){
                    $estudiante->IdEstudiante = $id;
                    return $this->respondUpdated($estudiante);
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
                $estudianteVerificado = $this->model->find($id);
                if($estudianteVerificado == null){
                    return $this->failNotFound('No se ha encorntrado un registro con el ID: '.$id. ' enviado');
                }
                
                if($this->model->delete($id)){
                    return $this->respondDeleted($estudianteVerificado);
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