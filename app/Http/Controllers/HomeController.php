<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Models\Shop\Zone;
use App\Models\TrainingContents\SubjectCategory;
use App\Models\TrainingContents\Training;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    use PostTrait;
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
        return view('site.consultant')->with('page_title', ' الإستشارات');
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

    public function womwn_details($id = 0)
    {
        return view('site.womwn_details')->with('page_title', 'قضايا المراة');
    }

    public function product_details($id = 0)
    {
        return view('site.womwn_details')->with('page_title', 'تفاصيل المنتج ');
    }

    public function myProfile($id = 0)
    {
        return view('site.profile')->with('page_title', 'صفحتي الشخصية');
    }

    public function courses($type = 'grid')
    {

        $Training = SubjectCategory::with(['trainings' => function ($sub) {
            $sub->with(['is_register', 'departments']);
        }])->get();

//        return dd($Training);
        $view = ($type == 'grid') ? 'courses' : 'courses_list';
        return view('site.' . $view)
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

    public function course_detail($id = 1)
    {
        $training = Training::find($id);
        return view('site.course_detail')
            ->with('training', $training)
            ->with('page_title', ' تفاصيل الدورة التدريبية');
    }


    public function getZones(Request $request)
    {
//       return $request['id'];

        $allZones = Zone::all()->where('parent', $request['id']);
        $zones = '';
        if ($allZones != null)
            foreach ($allZones as $zone) {
                $zones .= '<option value="' . $zone->id . '"> ' . $zone->name_ar . '</option>';

            }
        return response(['data' => $zones], 200);

    }


    public function Update_Admin_Details()
    {
        $admin = Admin::find(\auth()->id());
        return view('auth.update', compact('admin'));
    }

    public function Admin_update(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'ssn_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            "district_id" => "required_if:userType,seller|numeric",
            "gov_id" => "required_if:userType,seller|numeric",
            "sale_name" => "required_if:userType,seller",

        ];
        $messages = [
            'name.required' => 'قم بكتابة اسم المستخدم',
            'email.required' => 'يرجى كتابة الايميل',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $Admin = Admin::where('id', $request->id)->first();

        if ($Admin) {
            if ($request->password == '') {
                $Admin->update([
                    'name' => $request->name,
                    'email' => $request->email,

                    'image' => $this->Post_update($request, 'image', "IMG-", 'assets/images/', $Admin->image)
                ]);
            } else {
                $Admin->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'image' => $this->Post_update($request, 'image', "IMG-", 'assets/images/', $Admin->image)
                ]);

            }
            if ($Admin->type == 'seller') {
                $Admin->seller->update([
                    'sale_name' => $request->sale_name,
                    'gov_id' => $request->gov_id,
                    'district_id' => $request->district_id,
                    'ssn_image' => $this->Post_update($request, 'ssn_image', "IMG-", 'assets/images/', $Admin->seller->ssn_image)
                ]);
            }

            if ($Admin) {
                return redirect()->route('home');
            } else {
                return redirect()->back()->withErrors($Admin)->withInput();
            }
        }
}

}
