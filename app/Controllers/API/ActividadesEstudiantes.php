<?php
    namespace App\Controllers\API;

    use App\Models\ActividadesEstudiantesModel;
    use CodeIgniter\RESTful\ResourceController;
    use Exception;

    class ActividadesEstudiantes extends ResourceController{

        public function __construct()
        {
            $this->model = $this->setModel(new ActividadesEstudiantesModel());
        }
        public function index()
        {
           $actividadesEstudiantes = $this->model->findAll();
           return $this->respond($actividadesEstudiantes);
        }

        //servicio de insertar
        public function create (){
            try{
                $actividadesEstudiantes = $this->request->getJSON();
                if($this->model->insert($actividadesEstudiantes)){
                    $actividadesEstudiantes->Idactividad_estudiante = $this->model->insertID();
                    return $this->respondCreated($actividadesEstudiantes);
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
                $actividadesEstudiante = $this->model->find($id);
                if($actividadesEstudiante == null){
                    return $this->failNotFound('No se ha encorntrado un registro con el ID: '.$id. ' enviado');
                }
                return $this->respond($actividadesEstudiante);
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
                $actividadEstudianteVerificadas = $this->model->find($id);
                if($actividadEstudianteVerificadas == null){
                    return $this->failNotFound('No se ha encorntrado un registro con el ID: '.$id. ' enviado');
                }
                $actividadEstudiante = $this->request->getJSON();

                if($this->model->update($id, $actividadEstudiante)){
                    $actividadEstudiante->Idactividad_estudiante = $id;
                    return $this->respondUpdated($actividadEstudiante);
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
                $actividadEstudianteVerificado = $this->model->find($id);
                if($actividadEstudianteVerificado == null){
                    return $this->failNotFound('No se ha encorntrado un registro con el ID: '.$id. ' enviado');
                }
                
                if($this->model->delete($id)){
                    return $this->respondDeleted($actividadEstudianteVerificado);
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