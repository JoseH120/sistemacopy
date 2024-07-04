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
            'Usuario' => 'required|min_length[3]|max_length[500]',
            'Clave' => 'required|min_length[3]|max_length[500]',
            'Tipo' => 'required|numeric|less_than[4]|greater_than[0]'
        ];

        protected $validationMessages = [];

        protected $skipValidation = false;
    }
?>