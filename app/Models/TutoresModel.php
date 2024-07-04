<?php
    
    namespace App\Models;
    
    use CodeIgniter\Model; 

    class TutoresModel extends Model{

        protected $table = 'tutores';
        protected $primaryKey = 'IdTutor';
        protected $returnType = 'array';
        protected $allowedFields = ['Nombre', 'Apellido', 'Correo', 'Contacto', 'IdUsuario'];

        protected $useTimestamps = true;
        protected $createdField = 'created_at';
        protected $updatedField = 'updated_at';

        protected $validationRules = [
            'Nombre' => 'required|alpha_space|min_length[3]|max_length[500]',
            'Apellido' => 'required|alpha_space|min_length[3]|max_length[500]',
            'Correo' => 'required|valid_email|max_length[500]',
            'Contacto' => 'numeric',
            'IdUsuario' => 'numeric'
        ];

        protected $validationMessages = [
            'Correo' => [
                'valid_email' => 'Estimado usuario, debe ingresar un email valido'
            ]
        ];

        protected $skipValidation = false;
    }
?>