<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\TrainingContents\SubjectCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function showTrainingByCategory()
    {
        try {
            $Training = SubjectCategory::with(['subjects' => function ($q) {
                $q->with(['trainings' => function ($sub) {
                    $sub->with(['is_register', 'departments']);
                }]);
            }])->get();
            if (!$Training) {
                return $this->ReturnErorrRespons('0000', 'لايوجد منشورات');
            } else {
                return $this->GetDateResponse('Trainings', $Training);
            }
        } catch (\Exception $ex) {
            return $this->ReturnErorrRespons($ex->getCode(), $ex->getMessage());
        }
    }

}
