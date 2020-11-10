<?php

namespace App\Http\Controllers\AdminControllers\Training;

use App\Exam;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with('training')->get();
        return $exams;
    }

    public function index_1()
    {
        $exams = Question::with('exam')->get();
        return $exams;
    }
}
