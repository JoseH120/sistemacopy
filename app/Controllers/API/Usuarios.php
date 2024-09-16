<?php

namespace App\Controllers\API;

use App\Libraries\Oauth;
use App\Models\UsuariosModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Exception;
use OAuth2\Request;

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
            // unset($usuario->clave);
            // unset($usuario->clave, $usuario->created_at, $usuario->update_at);
            return $this->respond($usuario);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationError("No se ha enviado un ID valido.");
            }
            $usuario = $this->model->find($id);
            if ($usuario == null) {
                return $this->failValidationError("No se ha encontrado un registro con el ID " . $id . " enviado");
            }
            $data = $this->request->getJSON();
			$data['usuario'] = $this->request->getJsonVar('usuario');
            if ($this->model->update($id, $data)) {
                $data->IdUsuario = $id;
                return $this->respondUpdated($data);
            } else {
                return $this->failValidationError($this->model->validation->listErrors());
            }
        } catch (Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor.");;
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

    //AGREGANDO LOGIN FUNCTION
    public function login()
    {
        $oauth = new Oauth();
        $request = new Request();
        $respond = $oauth->server->handleTokenRequest($request->createFromGlobals());
        $code = $respond->getStatusCode();
        $body = $respond->getResponseBody();
        return $this->respond(json_decode($body), $code);
    }

    public function register()
    {
        helper('form');
        $data = [];

        if ($this->request->getMethod() != 'post') {
            return $this->fail('Only post request is allowed');
        }

        $rules = [
            'usuario' => ['rules' => 'required|min_length[3]|max_length[20]', 'label' => 'Usuario'],
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'tipo' => 'required',
            'clave' => 'required|min_length[8]',
            'clave_confirm' => 'matches[clave]',
        ];

        if (!$this->validate($rules)) {
            return $this->fail(implode('<br>', $this->validator->getErrors()));
        } else {
            $model = new UsuariosModel();

            $data = [
                'IdUsuario' =>  $this->request->getVar('idusuario'),
                'usuario' => $this->request->getVar('usuario'),
                'email' => $this->request->getVar('email'),
                'clave' => $this->request->getVar('clave'),
            ];

            $user_id = $model->insert($data);
            $data['IdUsuario'] = $user_id;
            unset($data['clave']);
            return $this->respondCreated($data);
        }
    }
}
