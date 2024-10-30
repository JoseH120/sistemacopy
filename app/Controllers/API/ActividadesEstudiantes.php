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
            $nombre = $_FILES['UrlTarea']['name'];
            $tipo = $_FILES['UrlTarea']['type'];
            $size =  $_FILES['UrlTarea']['size'];
            $temporal = $_FILES['UrlTarea']['tmp_name'];

            $Nota = $this->request->getVar('Nota');
            $IdActividad = $this->request->getVar('IdActividad');
            $IdEstudiante = $this->request->getVar('IdEstudiante');
            $nombre = str_replace(" ", "", $nombre);

            $UrlTarea = "http://localhost/sistema/uploads/tareas/".$IdActividad."/".$IdEstudiante."/".$nombre;

            $data = array('Nota' => $Nota , 'IdActividad' => $IdActividad, 
                'IdEstudiante' => $IdEstudiante, 'UrlTarea' => $UrlTarea);

            try{
                if($this->model->insert($data)){
                    $actividadesEstudiantes = json_encode($data, JSON_PRETTY_PRINT);
                    if($this->crear($temporal, $nombre, $IdActividad, $IdEstudiante)) 
                        return $this->respondCreated($actividadesEstudiantes);
                    else
                        return $this->failServerError('Ha ocurrido un error en el servidor.');
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
                return $this->failServerError('Ha ocurrido un error en el servidor'.$e);
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
        public function tareasByActividad($id = null){
            try{
                if($id == null){
                    return $this->failValidationError('No se ha recibido un ID valido');
                }
                $AE = $this->model->getTareasByActividad($id);
    
                return $this->respond($AE);
            }
            catch(Exception $e){
                return $this->failServerError('Ha ocurrido un error en el servidor'.$e->getMessage());
            }

        }
        private function crear($temporal, $nombre, $IdActividad, $IdEstudiante){
            $pathRelativa = "uploads/tareas/".$IdActividad."/".$IdEstudiante;
            if(!file_exists($pathRelativa)){
                mkdir($pathRelativa, 0777, true);
                if(file_exists($pathRelativa)){
                    if(move_uploaded_file($temporal, $pathRelativa.'/'.$nombre)){
                        return true;
                    }
                    else{
                        return false;
                    }
                }
            }
            else{
                if(move_uploaded_file($temporal, $pathRelativa.'/'.$nombre)){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }
?>