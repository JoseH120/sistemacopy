<?php
<<<<<<< HEAD
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
            'Usuario' => 'required|min_length[3]|max_length[500]',
            'Clave' => 'required|min_length[3]|max_length[500]',
            'Tipo' => 'required|numeric|less_than[4]|greater_than[0]'
        ];

        protected $validationMessages = [];

        protected $skipValidation = false;
    }
?>
=======

namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'IdUsuario';

    protected $returnType = 'array';
    protected $allowedFields = ['Usuario', 'Clave', 'Tipo'];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $skipValidation = false;

    protected $validationRules = [
        "Usuario" => 'required|max_length[30]|is_unique[usuarios.usuario]',
        "Clave" => 'required|max_length[255]|min_length[10]',
        "Tipo" => 'required',
    ];

    protected $validationMessages = [
        'Usuario' => [
            'max_length' => 'Debe tener 30 caracteres por lo menos',
            'is_unique' => 'El usuario se encunetra registrado',
        ],
        'Clave' => [
            'min_length' => 'Debe contener al menos 8 caracteres',
            'max_length' => 'Debe contener menos que 255 caracteres'
        ]
    ];
}
>>>>>>> b53f93c862bc4eafd8c83b328e5240e672a3c358
