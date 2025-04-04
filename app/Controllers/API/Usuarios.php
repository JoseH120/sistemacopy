<?php

namespace App\Controllers\API;

use App\Libraries\Oauth;
use App\Models\UsuariosModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Message;
use CodeIgniter\RESTful\ResourceController;
use Exception;
use OAuth2\Request;
use PhpParser\Node\Expr\Cast\String_;
use Predis\Command\Argument\Search\ExplainArguments;
use SebastianBergmann\CodeUnit\CodeUnit;

class Usuarios extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->model = $this->setModel(new UsuariosModel());
    }

    //Listar 
    public function index()
    {
        $usuarios = $this->model->findAll();
        return $this->respond($usuarios);
    }

    //Servicio de insertar
    public function create()
    {
        try {
            $usuario = $this->request->getJSON();
            if ($this->model->insert($usuario)) {
                $usuario->IdUsuario = $this->model->insertID();
                unset($usuario->clave);
                return $this->respondCreated($usuario);
            } else {
                return $this->failValidationError($this->model->validation->listErrors());
            }
        } catch (Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor." . $e->getMessage());
        }
    }


    //Servicio para obtener informacion de un usuario.
    public function edit($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationError('No se ha enviado un id valido.');
            }
            $usuario = $this->model->find($id);
            if ($usuario == null) {
                return $this->failNotFound("No se ha encontrado un registro con el id " . $id . " enviado");
            }
            return $this->respond($usuario);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update($id = null)
    {

        if ($id == null) {
            return $this->failValidationError("No se ha enviado un ID valido.");
        }
        $usuarioVerificado = $this->model->find($id);
        if ($usuarioVerificado == null) {
            return $this->failValidationError("No se ha encontrado un registro con el ID " . $id . " enviado");
        }
        $data = $this->request->getJSON();
        try {
            // echo ($data);
            if ($this->model->update($id, $data)) {
                $data->IdUsuario = $id;
                return $this->respondUpdated($data);
            } else {
                return $this->failValidationError($this->model->validation->listErrors());
            }
        } catch (Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor.");
            // return $this->failValidationError($this->model->validation->listErrors());
        }
    }

    public function delete($id = null)
    {
        try {
            $data = $this->model->find($id);
            if ($data == null) {
                return $this->failNotFound("No se ha encontrado un registro con el ID " . $id . " enviado");
            }
            return $this->model->delete($id)  ? $this->respondDeleted($data) : $this->failValidationError("No se pudo eliminar el registro.");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUsuariosNoAsignadosEstudiante()
    {
        $usuarios = $this->model->usuariosNoAsignadosEstudiante();
        return $this->respond($usuarios);
    }

    public function getUsuariosNoAsignadosTutor()
    {
        $usuarios = $this->model->usuariosNoAsignadosTutor();
        return $this->respond($usuarios);
    }

    //AGREGANDO LOGIN FUNCTION
    public function login()
    {
        $oauth = new Oauth();
        $request = new Request();
        $respond = $oauth->server->handleTokenRequest($request->createFromGlobals());
        $code = $respond->getStatusCode();
        $body = $respond->getResponseBody();
        //AGREGANDO DATOS DEL USUARIO LOGEADO POR MEDIO DEL CORREO DEL USUARIO
        if ($code === 200 || $code === 201) {
            $email = $this->request->getPost("username");
            $usuario = $this->model->getUsuarioByEmail($email);
            $idTutor = 0;
            //CONVIERTIENDO EL OBJECTO BODY A UN ARRAY MEDIANTE LA FUNCION JSON-DECODE
            $body = json_decode($body);
            //AGREGANDO EL ID TUTOR SI TIPO ES TUTOR
            if ($usuario->tipo ==  'TUTOR') {
                $idTutor = $this->model->getTutorId($usuario->idusuario);
                $final = array_merge((array)$body, (array)$usuario, (array)$idTutor);
            } else if ($usuario->tipo == 'ESTUDIANTE') {
                $idestudiante = $this->model->getEstudianteId($usuario->idusuario);
                $final = array_merge((array)$body, (array)$usuario, (array)$idestudiante);
            } else {
                $final = array_merge((array)$body, (array)$usuario);
            }

            //ENVIANDO EL TOKEN CON LOS DATOS DEL USUARIO
            return $this->respond($final, $code);
        } else {
            return $this->respond(json_decode($body), $code);
        }
    }
}
