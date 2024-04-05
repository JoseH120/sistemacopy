<?php

namespace App\Models\CustomRules;

use App\Models\TutoresModel;

class MyCustomRules
{
    public function is_valid_tutor(int $id): bool
    {
        $model = new TutoresModel();
        $tutor = $model->find($id);

        return $tutor == null ? false : true;
    }
}
