<<<<<<< HEAD
<?php

    namespace App\Models;

    use CodeIgniter\Model;

    class UsuariosModel extends Model{

        //Tipo = [ÄDMINISTRADOR => 1, TUTOR => 2, ESTUDIANTE => 3]

        protected $table = 'usuarios';
        protected $primaryKey = 'IdUsuario';
        protected $returnType = 'array';
        protected $allowedFields = ['Usuario', 'Clave', 'Tipo'];
        protected $useTimestamps = true;
        protected $createdField = 'created_at';
        protected $updatedField = 'updated_at';
        protected $validationRules = [
        "Usuario" => 'required|max_length[30]',
        "Clave" => 'required|max_length[255]|min_length[10]',
        "Tipo" => 'required',
        ];
        protected $validationMessages = [
            'Usuario' => [
                'required' => 'El valor "usuario" es requerido',
                'max_length' => '"Usuario" debe tener 30 caracteres como maximo'
            ],
            'Clave' => [
                'required' => 'El valor "contraseña" es requerido',     
                'min_length' => '"Contraseña" debe contener al menos 8 caracteres',
                'max_length' => '"Contraseña" debe contener menos que 255 caracteres'
            ],
            'Tipo' => [
                'required' => 'El valor "tipo" es requerido'
            ]
        ];
        protected $skipValidation = false;

        public function usuariosNoAsignados(){
            $builder = $this->db->table($this->table);
            $builder->select('IdUsuario, Usuario, Tipo');
            $builder->where('IdUsuario NOT IN (SELECT idusuario FROM tutores)');

            $query = $builder->get();

            return $query->getResult();
        }
    }


=======
<?php

namespace App\Models;

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
        "usuario" => 'required|max_length[20]|min_length[10]',
        "email" => 'required|valid_email|is_unique[usuarios.email]',
        "clave" => 'required|max_length[255]|min_length[8]',
        "tipo" => 'required',
    ];
    protected $validationMessages = [
        'usuario' => [
            'required' => 'El valor es requerido',
            'max_length' => 'Debe tener 30 caracteres como maximo'
        ],
        'email' => [
            'required' => 'El valor es requerido',
            'is_unique' => 'El email ya esta registrado',
        ],
        'clave' => [
            'required' => 'El valor es requerido',
            'min_length' => 'Debe contener al menos 8 caracteres',
            'max_length' => 'Debe contener menos que 255 caracteres'
        ],
        'tipo' => [
            'required' => 'El valor es requerido'
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
        // return $data;
    }

    protected function passwordHash(array $data)
    {
        if (isset($data['data']['clave'])) {
            $data['data']['clave']  = password_hash($data['data']['clave'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}
>>>>>>> loginfeature
