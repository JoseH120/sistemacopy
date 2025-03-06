<?php

namespace App\Models;

use CodeIgniter\Database\MySQLi\Builder;
use CodeIgniter\Model;

class UsuariosModel extends Model
{

    //Tipo = [ÄDMINISTRADOR => 1, TUTOR => 2, ESTUDIANTE => 3]


    protected $table = 'usuarios';
    protected $primaryKey = 'IdUsuario';
    protected $returnType = 'array';
    //    protected $allowedFields = ['Usuario', 'Clave', 'Tipo'];
    protected $allowedFields = ['usuario', 'email', 'clave', 'tipo'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $skipValidation = false;
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected $validationRules = [
        "usuario" => 'required|max_length[30]|min_length[10]',
        "email" => 'required|valid_email|is_unique[usuarios.email]',
        "clave" => 'required|max_length[255]|min_length[8]',
        "tipo" => 'required',
    ];
    protected $validationMessages = [
        'usuario' => [
            'required' => 'El valor usuario es requerido',
            'max_length' => 'Usuario debe tener 30 caracteres como maximo',
            'min_length' => 'Usuario debe tener 10 caracteres como minimo'
        ],
        'email' => [
            'required' => 'El valor email es requerido',
            'is_unique' => 'El email ya esta registrado',
        ],
        'clave' => [
            'required' => 'El valor clave es requerido',
            'min_length' => 'Clave debe contener al menos 8 caracteres',
            'max_length' => 'Clave debe contener menos que 255 caracteres'
        ],
        'tipo' => [
            'required' => 'El valor tipo es requerido'
        ]
    ];

    //AGREGANDO MECANISMO DE ENCRIPTACION DE CLAVE ANTES DE INSERTAR/ACTUALIZAR USUARIOS
    protected function beforeInsert(array $data)
    {
        $data = $this->passwordHash($data);
        return $data;
    }
    protected function beforeUpdate(array $data)
    {
        $data = $this->passwordHash($data);
        return $data;
    }

    protected function passwordHash(array $data)
    {
        if (isset($data['data']['clave'])) {
            $data['data']['clave']  = password_hash($data['data']['clave'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    public function usuariosNoAsignadosEstudiante()
    {
        $builder = $this->db->table($this->table);
        $builder->select('IdUsuario, Usuario, email, Tipo');
        $builder->where('Tipo = "ESTUDIANTE" and IdUsuario NOT IN (SELECT idusuario FROM estudiantes)');

        $query = $builder->get();

        return $query->getResult();
    }

    public function usuariosNoAsignadosTutor()
    {
        $builder = $this->db->table($this->table);
        $builder->select('IdUsuario, Usuario, email, Tipo');
        $builder->where('Tipo = "TUTOR" and IdUsuario NOT IN (SELECT idusuario FROM tutores)');

        $query = $builder->get();

        return $query->getResult();
    }

    public function getUsuarioByEmail($email)
    {
        $builder = $this->db->table($this->table);
        $builder->select('idusuario, usuario, tipo');
        $builder->where('email', $email);
        $query = $builder->get();
        return $query->getRowObject();
    }
    public function getTutorId($idUsuario)
    {
        $builder = $this->db->table('tutores');
        $builder->select('idtutor');
        $builder->where('idusuario', $idUsuario);
        $result = $builder->get();
        return $result->getRowObject();
    }
    public function getEstudianteId($idUsuario)
    {
        $builder = $this->db->table('estudiantes');
        $builder->select('idestudiante');
        $builder->where('idusuario', $idUsuario);
        $result = $builder->get();
        return $result->getRowObject();
    }
}
