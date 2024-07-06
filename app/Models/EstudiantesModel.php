<?php

    namespace App\Models;

    use CodeIgniter\Model;

    class EstudiantesModel extends Model{
        
        protected $table = 'estudiantes';
        protected $primaryKey = 'IdEstudiante';

        protected $returnType = 'array';
        protected $allowedFields = ['PrimerNombre', 'SegundoNombre', 'PrimerApellido', 'SegundoApellido', 'Dui', 
                                    'Direccion', 'FechaNacimiento', 'Responsable', 'Correo', 
                                    'VacunaCovid', 'IdUsuario'];

        protected $useTimestamps = true;
        protected $createdField = 'created_at';
        protected $updatedField = 'updated_at';

        protected $validationRules = [
            'PrimerNombre' => 'required|alpha|min_length[3]|max_length[500]',
            'SegundoNombre' => 'required|alpha|min_length[3]|max_length[500]',
            'PrimerApellido' => 'required|alpha|min_length[3]|max_length[500]',
            'SegundoApellido' => 'required|alpha|min_length[3]|max_length[500]',
            'Dui' => 'permit_empty|exact_length[9,10]',
            'Direccion' => 'required|alpha_dash|min_length[3]|max_length[500]',
            'FechaNacimiento' => 'required|valid_date',
            'Responsable' => 'permit_empty|alpha_space|min_length[3]|max_length[500]',
            'Correo' => 'permit_empty|valid_email',
            'VacunaCovid' => 'required|numeric|greater_than[0]|less_than[3]',
            'IdUsuario' => 'required|numeric|is_valid_usuario'
        ];

        protected $validationMessages = [
            'PrimerNombre' => [
                'required' => 'El valor es requerido',
                'alpha' => 'El nombre solo debe contener letras del alfabeto',
                'min_length' => 'Debe ser mayor que 3 caracteres',
                'max_length' => 'Debe ser menor de 500 caracteres'

            ],
            'SegundoNombre' => [
                'required' => 'El valor es requerido',
                'alpha' => 'El nombre solo debe contener letras del alfabeto',
                'min_length' => 'Debe ser mayor que 3 caracteres',
                'max_length' => 'Debe ser menor de 500 caracteres'

            ],
            'PrimerApellido' => [
                'required' => 'El valor es requerido',
                'alpha' => 'El apellido solo debe contener letras del alfabeto',
                'min_length' => 'Debe ser mayor que 3 caracteres',
                'max_length' => 'Debe ser menor de 500 caracteres'

            ],
            'SegundoApellido' => [
                'required' => 'El valor es requerido',
                'alpha' => 'El apellido solo debe contener letras del alfabeto',
                'min_length' => 'Debe ser mayor que 3 caracteres',
                'max_length' => 'Debe ser menor de 500 caracteres'

            ],
            'Dui' => [
                'exact_length' => 'Debe tener entre 9 a 10 caracteres para ser aceptado'
            ],
            'Direccion' => [
                'required' => 'El valor es requerido',
                'alpha_dash' => 'solo recibe caracteres alfanuméricos, guiones bajos o guiones en ASCII',
                'min_length' => 'Debe ser mayor que 3 caracteres',
                'max_length' => 'Debe ser menor de 500 caracteres'
            ],
            'FechaNacimiento' => [
                'required' => 'El valor es requerido',
                'valid_date' => 'La fecha es invalida',
            ],
            'Responsable' => [
                'alpha_space' => 'Solo debe contener letras del alfabeto y espacios',
                'min_length' => 'Debe ser mayor que 3 caracteres',
                'max_length' => 'Debe ser menor de 500 caracteres'
            ],
            'Correo' => [
                'valid_email' => 'Estimado usuario, debe ingresar un email valido'
            ],
            'VacunaCovid' => [
                'required' => 'El valor es requerido',
                'numeric'=> 'Debe ingresar un numero',
                'greater_than' => 'El numero dene ser mayor que 0',
                'less_than' => 'El numero dene ser menor que 3',
            ],
            'IdUsuario' => [
                'required' => 'El valor es requerido',
                'numeric'=> 'Debe ingresar un numero',
                'is_valid_usuario' => 'el id usuario no existe'
            ]
        ];

        protected $skipValidation = false;
    }
?>