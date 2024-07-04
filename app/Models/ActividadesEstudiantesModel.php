<?php
    namespace App\Models;

    use CodeIgniter\Model;

    class ActividadesEstudiantesModel extends Model{
        protected $table = 'actividades_estudiantes';
        protected $primaryKey = 'Idactividades_estudiantes';
        protected $returnType = 'array';
        protected $allowedFields = ['Nota', 'UrlTarea', 'IdActividad'];
        protected $useTimestamps = true;
        protected $createdField = 'created_at';
        protected $updatedField = 'updated_at';
        protected $validationRules = [
            'Nota' => 'required|numeric|less_than[11]|greater_than[0]',
            'UrlTarea' => 'required|min_length[3]|max_length[600]',
            'IdActividad' => 'required|numeric'
        ];

        protected $validationMessages = [];

        protected $skipValidation = false;
    }
?>