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
            $nombre = $_FILES['UrlRecurso']['name'];
            $tipo = $_FILES['UrlRecurso']['type'];
            $size =  $_FILES['UrlRecurso']['size'];
            $temporal = $_FILES['UrlRecurso']['tmp_name'];

            $Tema = $this->request->getVar('Tema');
            $Descripcion = $this->request->getVar('Descripcion');
            $IdCurso = $this->request->getVar('IdCurso');
            
            $TemaCarpeta = str_replace(" ", "", $Tema);
            $nombre = str_replace(" ", "", $nombre);
            $UrlRecurso = "http://localhost/sistema/uploads/actividades/".$IdCurso."/".$TemaCarpeta."/".$nombre;
                    

            $data = array('Tema' => $Tema , 'Descripcion' => $Descripcion, 
                'IdCurso' => $IdCurso, 'UrlRecurso' => $UrlRecurso);
            

            try{
                if($this->model->insert($data)){
                    $actividad = json_encode($data, JSON_PRETTY_PRINT);
                    if($this->crear($temporal, $nombre, $IdCurso, $TemaCarpeta)) 
                        return $this->respondCreated($actividad);
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
                $nombre = $_FILES["UrlRecurso"]["name"];
                $tipo = $_FILES['UrlRecurso']['type'];
                $size =  $_FILES['UrlRecurso']['size'];
                $temporal = $_FILES['UrlRecurso']['tmp_name'];
                   
                $Tema = $this->request->getVar('Tema');
                $Descripcion = $this->request->getVar('Descripcion');
                $IdCurso = $this->request->getVar('IdCurso');
            
                $TemaCarpeta = str_replace(" ", "", $Tema);
                $nombre = str_replace(" ", "", $nombre);
                $UrlRecurso = "http://localhost/sistema/uploads/actividades/".$IdCurso."/".$TemaCarpeta."/".$nombre;
                    

                $data = array('Tema' => $Tema , 'Descripcion' => $Descripcion, 
                'IdCurso' => $IdCurso, 'UrlRecurso' => $UrlRecurso);
                   
                if($id == null){
                    return $this->failValidationError('No se ha enviado un id valido');
                }
                $actividadVerificado = $this->model->find($id);
                if($actividadVerificado == null){
                    return $this->failNotFound('No se ha encorntrado un registro con el ID: '.$id. ' enviado');
                }
                $TemaCarpetaOld = str_replace(" ", "", $actividadVerificado['Tema']);
                $directorio = "uploads/actividades/".$actividadVerificado['IdCurso']."/".$TemaCarpetaOld;
                    
                if($this->model->update($id, $data)){                    
                    $file = substr($actividadVerificado['UrlRecurso'], 25, strlen($actividadVerificado['UrlRecurso']));
                    unlink($file);
                    rmdir($directorio);
                    if($this->crear($temporal, $nombre, $IdCurso, $TemaCarpeta)){
                        $actividad = json_encode($data, JSON_PRETTY_PRINT);
                        return $this->respondUpdated($actividad);
                    }
                    else{
                        return $this->failServerError('Ha ocurrido un error en el servidor.'); 
                    }     
                }
                else{
                    return $this->failValidationError($this->model->validation->listErrors());
                }                
            } catch (Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor ');
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
                    $TemaCarpeta = str_replace(" ", "", $actividadVerificada['Tema']);    
                    $directorio = "uploads/actividades/".$actividadVerificada['IdCurso']."/".$TemaCarpeta; 
                    $file = substr($actividadVerificada['UrlRecurso'], 25, strlen($actividadVerificada['UrlRecurso']));
                    unlink($file);
                    rmdir($directorio);
                    return $this->respondDeleted($actividadVerificada);
                }
                else{
                    return $this->failValidationError('No se ha podido eliminar el registro');
                }
            } catch (Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor '.$e);
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

        private function crear($temporal, $nombre, $IdCurso, $Tema){
            $pathRelativa = 'uploads/actividades/'.$IdCurso."/".$Tema;
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