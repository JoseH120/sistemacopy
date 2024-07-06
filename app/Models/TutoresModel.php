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
            'Contacto' => 'permit_empty|numeric',
            'IdUsuario' => 'numeric|is_valid_usuario'
        ];

        protected $validationMessages = [
            'Nombre' => [
                'required' => 'El valor es requerido',
                'alpha_space' => 'Solo debe contener letras del alfabeto y espacios',
                'min_length' => 'Debe ser mayor que 3 caracteres',
                'max_length' => 'Debe ser menor de 500 caracteres'
            ],
            'Apellido' => [
                'required' => 'El valor es requerido',
                'alpha_space' => 'Solo debe contener letras del alfabeto y espacios',
                'min_length' => 'Debe ser mayor que 3 caracteres',
                'max_length' => 'Debe ser menor de 500 caracteres'
            ],
            'Correo' => [
                'required' => 'El valor es requerido',
                'valid_email' => 'Estimado usuario, debe ingresar un email valido',
                'max_length' => 'Debe ser menor de 500 caracteres'
            ],
            'Contacto' => [
                'numeric'=> 'Debe ingresar un numero'
            ],
            'IdUsuario' => [
                'numeric'=> 'Debe ingresar un numero',
                'is_valid_usuario' => 'el id usuario no existe'
            ]
        ];

        protected $skipValidation = false;
    }
?>