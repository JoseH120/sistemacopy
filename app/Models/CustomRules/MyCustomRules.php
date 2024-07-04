<?php

namespace App\Models\CustomRules;

use App\Models\TutoresModel;

class MyCustomRules
{
    public function is_valid_tutor($id)
    {
        $model = new TutoresModel();
        $tutor = $model->find($id);

        return $tutor == null ? false : true;
    }
}
