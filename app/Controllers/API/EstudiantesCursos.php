<?php
    namespace App\Controllers\API;

    use CodeIgniter\RESTful\ResourceController;
    use App\Models\EstudiantesCursosModel;
    use Exception;

    class EstudiantesCursos extends ResourceController{

        public function __construct(){
            $this->model = $this->setModel(new EstudiantesCursosModel());
        }

        public function index(){
            $estudiantesCursos = $this->model->findAll();
            return $this->respond($estudiantesCursos);  
        }

        public function create(){
            try{
                $estudiantesCursos = $this->request->getJSON();
                if($this->model->insert($estudiantesCursos)){
                    $estudiantesCursos->Idestudiante_curso = $this->model->insertID();
                    return $this->respondCreated($estudiantesCursos);
                }
                else{
                    return $this->failValidationError($this->model->listErrors());
                }
            }
            catch(Exception $e){
                return $this->failServerError('Ha ocurrido un error en el servidor.'.$e->getMessage());
            }
        }

        //servicio para buscar un registro
        public function edit($id = null){
            try{
                if($id == null){
                    return $this->failValidationError('No se ha enviado un ID valido');
                }
                $estudiantesCursos = $this->model->find($id);
                if($estudiantesCursos == null){
                    return $this->failNotFound('No se ha encontrado un registro con el ID: '.$id.' enviado');
                }
                else{
                    return $this->respond($estudiantesCursos);
                }
            }
            catch(Exception $e){
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }

        //Servicio de Actualizar un registro 
        public function update($id = null){
            try {
                if($id == null){
                    return $this->failValidationError('No se ha enviado un ID valido');
                }
                $estudianteCurso = $this->model->find($id);
                if($estudianteCurso == null){
                    return $this->failNotFound('No se ha encontrado un registro con el ID: '.$id.' enviado');
                }

                $data = $this->request->getJSON();
                if($this->model->update($id, $data)){
                    $data->Idestudiante_curso = $id;
                    return $this->respondUpdated($data);
                }
                else{
                    return $this->failValidationError($this->model->validation->listErrors());
                }
            }
            catch (Exception $e) {
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }

        //Servivio para eliminar un registro 
        public function delete($id = null){
            try{
                $data = $this->model->find($id);
                if($data == null){
                    return $this->failNotFound('No se ha encontrado un registro con el ID: '.$id.' enviado');
                }
                return $this->model->delete($id) ? $this->respondDeleted($data) : $this->failValidationError('No se ha podido eliminar el registro');
            }
            catch(Exception $e){
                return $this->failServerError('Ha ocurrido un error en el servidor.');
            }
        }

    }
?>