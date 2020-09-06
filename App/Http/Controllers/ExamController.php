<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Question;
use Illuminate\Http\Request;

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
