<?php

namespace App\Http\Controllers;

use App\EmployeeCategory;
use App\Traits\JsonTrait;
use App\Traits\PostTrait;
use Illuminate\Http\Request;

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
