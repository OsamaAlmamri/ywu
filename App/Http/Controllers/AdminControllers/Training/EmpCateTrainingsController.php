<?php

namespace App\Http\Controllers\AdminControllers\Training;

use App\EmployeeCategory;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmpCateTrainingsController extends Controller
{
    use JsonTrait;
    use PostTrait;

    public function index()
    {
        $Training = EmployeeCategory::with(['trainings'])->orderByDesc('id')->paginate(5);
        if (!$Training) {
            return $this->ReturnErorrRespons('0000', 'لايوجد منشورات');
        } else {
            return $this->GetDateResponse('Categories', $Training);
        }
    }
}
