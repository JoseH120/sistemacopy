<?php

namespace App\Models\CustomRules;

use App\Models\ActividadesModel;
use App\Models\CursosModel;
use App\Models\EstudiantesModel;
use App\Models\TutoresModel;
use App\Models\UsuariosModel;

class MyCustomRules
{
    
    public function is_valid_curso($id)
    {
        $model = new CursosModel();
        $curso = $model->find($id);

        return ($curso == null) ? false : true;
    }

    public function is_valid_actividad($id)
    {
        $model = new ActividadesModel();
        $actividad = $model->find($id);

        return ($actividad == null) ? false : true;
    }

    public function is_valid_tutor($id)
    {
        $model = new TutoresModel();
        $tutor = $model->find($id);

        return ($tutor == null) ? false : true;
    }

    public function is_valid_usuario($id)
    {
        $model = new UsuariosModel();
        $usuario = $model->find($id);

        return ($usuario == null) ? false : true;
    }

    public function is_valid_estudiante($id)
    {
        $model = new EstudiantesModel();
        $estudiante = $model->find($id);

        return ($estudiante == null) ? false : true;
    }
}
