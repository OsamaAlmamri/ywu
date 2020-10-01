<?php

namespace App\Http\Controllers;

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
        return view('site.home');
    }
    public function training()
    {
        return view('site.courses');
    }
    public function consultant()
    {
        return view('site.consultant');
    }
    public function women()
    {
        return view('site.woman');
    }
    public function courses()
    {
        return view('site.courses');
    }
    public function privacy()
    {
        return view('site.privacy');
    }
    public function concatUs()
    {
        return view('site.concatUs');
    }
    public function about()
    {
        return view('site.about');
    }
    public function course_detail()
    {
        return view('site.course_detail');
    }
}
