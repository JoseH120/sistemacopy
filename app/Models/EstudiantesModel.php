<?php

namespace App\Models;

use CodeIgniter\Model;

class EstudiantesModel extends Model
{

    protected $table = 'estudiantes';
    protected $primaryKey = 'IdEstudiante';

    protected $returnType = 'array';
    protected $allowedFields = [
        'PrimerNombre',
        'SegundoNombre',
        'PrimerApellido',
        'SegundoApellido',
        'Dui',
        'Direccion',
        'FechaNacimiento',
        'Responsable',
        'Correo',
        'VacunaCovid',
        'IdUsuario'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'PrimerNombre' => 'required|alpha|min_length[3]|max_length[500]',
        'SegundoNombre' => 'required|alpha|min_length[3]|max_length[500]',
        'PrimerApellido' => 'required|alpha|min_length[3]|max_length[500]',
        'SegundoApellido' => 'required|alpha|min_length[3]|max_length[500]',
        'Dui' => 'permit_empty|exact_length[9,10]',
        'Direccion' => 'required|alpha_numeric_space|min_length[3]|max_length[500]',
        'FechaNacimiento' => 'required|valid_date',
        'Responsable' => 'permit_empty|alpha_space|min_length[3]|max_length[500]',
        'Correo' => 'permit_empty|valid_email',
        'VacunaCovid' => 'required|numeric|greater_than[0]|less_than[3]',
        'IdUsuario' => 'required|numeric|is_valid_usuario'
    ];

    protected $validationMessages = [
        'PrimerNombre' => [
            'required' => 'El valor "primer nombre" es requerido',
            'alpha' => 'El "primer nombre" solo debe contener letras del alfabeto',
            'min_length' => '"Primer nombre" debe ser mayor que 3 caracteres',
            'max_length' => '"Primer nombre" debe ser menor de 500 caracteres'

        ],
        'SegundoNombre' => [
            'required' => 'El valor "segundo nombre" es requerido',
            'alpha' => 'El "segundo nombre" solo debe contener letras del alfabeto',
            'min_length' => '"Segundo nombre" debe ser mayor que 3 caracteres',
            'max_length' => '"Segundo nombre" debe ser menor de 500 caracteres'

        ],
        'PrimerApellido' => [
            'required' => 'El valor "primer apellido" es requerido',
            'alpha' => 'El "primer apellido" solo debe contener letras del alfabeto',
            'min_length' => '"Primer apellido" debe ser mayor que 3 caracteres',
            'max_length' => '"Primer apellido" debe ser menor de 500 caracteres'

        ],
        'SegundoApellido' => [
            'required' => 'El valor "segundo apellido" es requerido',
            'alpha' => 'El "segundo apellido" solo debe contener letras del alfabeto',
            'min_length' => '"Segundo apellido" debe ser mayor que 3 caracteres',
            'max_length' => '"Segundo apellido" debe ser menor de 500 caracteres'

        ],
        'Dui' => [
            'exact_length' => '"DUI" debe tener entre 9 a 10 caracteres para ser aceptado'
        ],
        'Direccion' => [
            'required' => 'El valor "direccion" es requerido',
            'alpha_numeric_space' => '"Direccion" solo recibe caracteres alfanuméricos, y espacios en ASCII',
            'min_length' => '"Direccion" debe ser mayor que 3 caracteres',
            'max_length' => '"Direccion" debe ser menor de 500 caracteres'
        ],
        'FechaNacimiento' => [
            'required' => 'El valor "fecha nacimiento" es requerido',
            'valid_date' => 'La fecha es invalida',
        ],
        'Responsable' => [
            'alpha_space' => 'El nombre del "responsable" solo debe contener letras del alfabeto y/o espacios',
            'min_length' => 'El nombre del "responsable" debe ser mayor que 3 caracteres',
            'max_length' => 'El nombre del "responsable" debe ser menor de 500 caracteres'
        ],
        'Correo' => [
            'valid_email' => 'Estimado usuario, debe ingresar un email valido'
        ],
        'VacunaCovid' => [
            'required' => 'El valor "vacuna COVID" es requerido',
            'numeric' => '"Vacuna COVID" debe ser un numero entre [1-2]',
            'greater_than' => 'El numero "vacuna COVID" debe ser mayor que 0',
            'less_than' => 'El numero "vacuna COVID" debe ser menor que 3',
        ],
        'IdUsuario' => [
            'required' => 'El valor "ID usuario" es requerido',
            'numeric' => 'El "ID usuario" debe ser un numero',
            'is_valid_usuario' => 'el id usuario no existe'
        ]
    ];

    protected $skipValidation = false;

    public function estudiantes( $id = null)
    {
        if($id == null){
            return null;
        }
        $builder = $this->db->table($this->table . ' e');
        $builder->select('e.IdEstudiante, CONCAT(e.PrimerNombre, " ", e.SegundoNombre) Nombre');
        $builder->select('CONCAT(e.PrimerApellido, " ", e.SegundoApellido) Apellido');
        $builder->where('e.IdEstudiante NOT IN (SELECT ec.IdEstudiante FROM estudiantes_cursos ec WHERE ec.IdCurso = '.$id.' )');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getEstudiante($id)
    {
        $builder = $this->db->table($this->table);
        $builder->select('idestudiante');
        $builder->where('idusuario', $id);
        $query = $builder->get();
        return $query->getRowObject();
    }
}
