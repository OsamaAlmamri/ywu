<?php

namespace App\Http\Controllers;

use App\Models\TrainingContents\SubjectCategory;
use App\Models\TrainingContents\Training;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('site.home')->with('page_title', '  الرئيسية');
    }

    public function training()
    {
        return view('site.courses')->with('page_title', ' الدورات التدريبية');
    }

    public function consultant()
    {
        return view('site.consultant')->with('page_title', ' الاستشارات');
    }

    public function login()
    {
        return view('site.login')->with('page_title', ' تسجيل الدخول');
    }
    public function register()
    {
        return view('site.register')->with('page_title', ' انشاء حساب جديد');
    }

    public function women()
    {
        return view('site.woman')->with('page_title', 'قضايا المراة');
    }

    public function womwn_details($id=0)
    {
        return view('site.womwn_details')->with('page_title', 'قضايا المراة');
    }
    public function myProfile($id=0)
    {
        return view('site.profile')->with('page_title', 'صفحتي الشخصية');
    }

    public function courses($type='grid')
    {
        $Training = SubjectCategory::with(['subjects' => function ($q) {
            $q->with(['trainings' => function ($sub) {
                $sub->with(['is_register', 'departments']);
            }]);
        }])->get();

//        return dd($Training);
       $view= ($type=='grid')?'courses':'courses_list';
        return view('site.'.$view)
            ->with('sections', $Training)
            ->with('page_title', ' الدورات التدريبية');
    }

    public function privacy()
    {
        return view('site.privacy')->with('page_title', 'سياسة  الخصوصية');;
    }

    public function concatUs()
    {
        return view('site.concatUs')->with('page_title', ' تواصل معنا');
    }

    public function about()
    {
        return view('site.about')->with('page_title', 'عنا ');
    }

    public function course_detail($id=1)
    {
        $training=Training::find($id);
        return view('site.course_detail')
            ->with('training',$training)
            ->with('page_title', ' تفاصيل الدورة التدريبية');
    }
}
