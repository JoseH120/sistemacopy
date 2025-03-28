<?php

namespace App\Controllers\API;

use App\Models\LeccionesModel;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class Lecciones extends ResourceController{
    
    public function __construct()
    {
        $this->model = $this->setModel(new LeccionesModel());
    }

    //Listar todo
    public function index()
    {
        $lecciones = $this->model->orderBy('FechaPublicacion','desc')->findAll();
        return $this->respond($lecciones);
    }

    public function leccionesByCurso($idCurso)
    {
        $lecciones = $this->model->where('IdCurso', $idCurso)->orderBy('FechaPublicacion','desc')->findAll();
        return $this->respond($lecciones);
    }

    //servicio de insertar
    public function create()
    {
        //Se obtienen los campos del formulario enviado
        $Tema = $this->request->getVar('Tema');
        $Descripcion = $this->request->getVar('Descripcion');
        $FechaPublicacion = $this->request->getVar('FechaPublicacion');
        $IdCurso = $this->request->getVar('IdCurso');
        $Url = $this->request->getVar('Url');

        //Construimos el array para insertar en la tabla
        $lecciones = array('Tema' => $Tema , 'Descripcion' => $Descripcion,
                'FechaPublicacion' => $FechaPublicacion, 
                'IdCurso' => $IdCurso);

        //Validamos si han enviado un archivo
        if(isset($_FILES['file'])){
            //Obtnemos los datos del archivo enviado
            $nombre = $_FILES['file']['name'];
            $tipo = $_FILES['file']['type'];
            $size =  $_FILES['file']['size'];
            $temporal = $_FILES['file']['tmp_name'];
            
            //Contruccion de la url del archivo para almacenar en database
            $URLArchivo = "http://localhost/sistema/uploads/lecciones/"
            .$IdCurso."/".str_replace(" ", "", $Tema)."/".str_replace(" ", "", $nombre);

            //Agregamos la llave y el valor al array que retornaremos en caso de exito
            $lecciones['Url'] = $URLArchivo;
        }
        //Validamos si han enviado un enlace
        else if(isset($Url)){
            //Agregamos la llave y el valor al array que retornaremos en caso de exito
            $lecciones['Url'] = $Url;
        }   

        try { 
            ///Insertamos a la base de datos
            if ($this->model->insert($lecciones)) {

                //Recuperamos el id de la ultima insercion
                $lecciones['IdLeccion'] = $this->model->insertID();

                ///creamos el archivo fisico en el servidor en caso que hallan enviado un file
                if(isset($_FILES['file'])){
                    if($this->crear($temporal, str_replace(" ", "", $nombre), $IdCurso, str_replace(" ", "", $Tema))){
                        //Respondemos exitosamente.
                        return $this->respondCreated($lecciones);
                    }
                }
                
                ///Este retorno se ejecuta si no hay un archivo para almacenar
                return $this->respondCreated($lecciones);
            } else {
                //Retorna los mensajes de validacion ya que no se pudo insertar por ese motivo.
                return $this->failValidationError($this->model->validation->listErrors());
            }
        } catch (Exception $e) {
            //Cachamos cualquier otro error.
            return $this->failServerError('Ha ocurrido un error en el servidor.');
        }
    }

    //Servicio para buscar un registro
    public function edit($id = null){
        try {
            if($id == null){
                return $this->failValidationErrors('No se ha enviado un id valido');
            }
            $leccion = $this->model->find($id);
            if($leccion == null){
                return $this->failNotFound('No se ha encorntrado un registro con el ID: '.$id. ' enviado');
            }
            return $this->respond($leccion);
        } catch (Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        } 
    }

    //Servicio de actualizar un registro
    public function update($id = null){
        if($id == null){
            return $this->failValidationError('No se ha enviado un id valido');
        }
        try{
            $leccionVerificada = $this->model->find($id);
            
            if($leccionVerificada == null){
                return $this->failNotFound('No se ha encorntrado un registro con el ID: '.$id. ' enviado');
            }

            $Tema = $this->request->getVar('Tema');
            $Descripcion = $this->request->getVar('Descripcion');
            $FechaPublicacion = $this->request->getVar('FechaPublicacion');
            $IdCurso = $this->request->getVar('IdCurso');

            $lecciones = array('Tema' => $Tema , 'Descripcion' => $Descripcion,
                'FechaPublicacion' => $FechaPublicacion, 
                'IdCurso' => $IdCurso);
            
            if(isset($_FILES['file'])){
                $nombre = $_FILES['file']['name'];
                $tipo = $_FILES['file']['type'];
                $size =  $_FILES['file']['size'];
                $temporal = $_FILES['file']['tmp_name'];

                $URLArchivo = "http://localhost/sistema/uploads/lecciones/"
                            .$IdCurso."/".str_replace(" ", "", $Tema)."/".str_replace(" ", "", $nombre);
                            
                if($leccionVerificada['Url'] != null){
                    $Tema = str_replace(" ", "", $lecciones['Tema']);    
                    $directorio = "uploads/lecciones/".$lecciones['IdCurso']."/".$Tema; 
                    $file = substr($leccionVerificada['Url'], 25, strlen($leccionVerificada['Url']));
                        
                    if($this->eliminar($file, $directorio)){
                        if($this->crear($temporal, str_replace(" ", "", $nombre), 
                        $IdCurso, str_replace(" ", "", $Tema))){
                            $lecciones['Url'] = $URLArchivo;
                        }
                    }
                }
                else{
                    if($this->crear($temporal, str_replace(" ", "", $nombre), 
                    $IdCurso, str_replace(" ", "", $Tema))){
                        $lecciones['Url'] = $URLArchivo;
                    }
                }
            }

            if($leccionVerificada['Url'] != null){
                $URLArchivo = "uploads/lecciones/"
                    .$IdCurso."/".str_replace(" ", "", $Tema);

                $direct = "uploads/lecciones/".$IdCurso."/".str_replace(" ", "", $leccionVerificada['Tema']);

                $handler = opendir($direct);

                while(($file = readdir($handler)) !== false){
                
                        $lecciones['Url'] = "http://localhost/sistema/uploads/lecciones/".$IdCurso."/"
                    .str_replace(" ", "", $Tema)."/".$file;

              
                }

                closedir($handler);

                if(rename($direct, $URLArchivo)){
                    if($this->model->update($id, $lecciones)){
                        $lecciones['IdLeccion'] = $id;
                        return $this->respondUpdated($lecciones);
                    }
                }
            }

            if($this->model->update($id, $lecciones)){
                $lecciones['IdLeccion'] = $id;
                return $this->respondUpdated($lecciones);
            }
            else {
                return $this->failValidationError($this->model->validation->listErrors());
            }
        }
        catch(Exceptio $e){
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }

    }

    public function delete($id = null){
        try{
            if($id == null){
                return $this->failValidationError('No se ha enviado un id valido');
            }
            $leccionVerificada = $this->model->find($id); 
            if($leccionVerificada == null){
                return $this->failNotFound('No se ha encorntrado un registro con el ID: '.$id. ' enviado');
            }
            if($this->model->delete($id)){

                if($leccionVerificada['Url'] != null){
                    $Tema = str_replace(" ", "", $leccionVerificada['Tema']);    
                    $directorio = "uploads/lecciones/".$leccionVerificada['IdCurso']."/".$Tema; 
                    $file = substr($leccionVerificada['Url'], 25, strlen($leccionVerificada['Url']));

                    if($this->eliminar($file, $directorio)){
                        return $this->respondDeleted($leccionVerificada);
                    }
                }
                return $this->respondDeleted($leccionVerificada);
            }
            else{
                return $this->failValidationError('No se ha podido eliminar el registro');
            }
        }
        catch(Exception $e){
            return $this->failServerError('Ha ocurrido un error en el servidor '.$e);
        }
    }

    private function crear($temporal, $nombre, $IdCurso, $Tema){
        $pathRelativa = 'uploads/lecciones/'.$IdCurso."/".$Tema;
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

    private function eliminar($file, $directorio){
        
        if(unlink($file)){
            if(rmdir($directorio)){
                return true;
            }
        }
        else{
            return false;
        }
        
    }
}