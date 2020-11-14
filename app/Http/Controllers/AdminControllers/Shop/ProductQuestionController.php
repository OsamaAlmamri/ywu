<?php

namespace App\Http\Controllers\AdminControllers\Shop;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use App\Models\Shop\ProductQuestion;
use App\Models\Shop\ProductsOption;
use App\Models\Shop\QuestionReplay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class ProductQuestionController extends Controller

{
    public function index()
    {
        if (request()->ajax()) {
            $has_category = false;
            if (isset(request()->category_id) and request()->category_id > 0)
                $has_category = true;
            $data = ProductQuestion::whereIn('product_id', function ($query) use ($has_category) {
                    $query->select('id')
                        ->from(with(new Product())->getTable())
                        ->where('admin_id', auth()->id());
                    if ($has_category) {
                        $query->where('category_id', request()->category_id);
                    }
                })->get();
            if ($data) {
                return datatables()->of($data)
                    ->addColumn('action', 'admin.shop.product_questions.btn.action')
                    ->addColumn('btn_sort', 'sortFiles.btn_sort')
                    ->addColumn('btn_status', 'admin.shop.product_questions.btn.status')
                    ->addColumn('reples', 'admin.shop.product_questions.btn.reples')
                    ->rawColumns(['action', 'btn_sort', 'reples', 'btn_status'])
                    ->make(true);
            }
        }
        return view('admin.shop.product_questions.index');
    }

    public function active(Request $r)
    {
        $new_status = 1;
        if ($r->status == 1)
            $new_status = 0;
        $user = ProductQuestion::find($r->id);
        $user->status = $new_status;
        $user->save();
        return $new_status;
    }

    public function replay_product_questions(Request $request)
    {
        $dada = array(
            'product_question_id' => $request->ques_ques_id,
            'text' => $request->reply,
            'replay_user_id' => auth()->user()->id,
            'replay_user_type' => 'admin',
        );
        if ($request->ques_ques_replay_id == 0)
            $replay = QuestionReplay::create($dada);
        else {
            $replay = QuestionReplay::find($request->ques_ques_replay_id);
            $replay->update($dada);
        }
        return response($replay, 200);
    }

    public function delete_replay(Request $request)
    {

        $replay = QuestionReplay::find($request->reply_id)->delete();

        return response($replay == true ? 1 : 0, 200);
    }

    public function edit_product_questions($id, $status)
    {
        $pro = ProductsOption::find($id);
        if ($status == 1)
            $pro->update(['status' => 1, 'question_read' => 1]);
        elseif ($status == 0)
            $pro->update(['question_read' => 1]);
        else
            $pro->update(['status' => 0, 'question_read' => 1]);
        $message = Lang::get("labels.product_question_updateMessage");
        return redirect()->back()->withErrors([$message]);

    }

    public
    function changeOrder(Request $request)
    {
        $sortData = ProductQuestion::all();
        foreach ($sortData as $element) {
            $element->timestamps = false; // To disable update_at field updation
            $id = $element->id;
            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $element->update(['sort' => $order['position']]);
                }
            }
        }
        return response('Update Successfully.', 200);
    }


    public function show_replies($id)
    {
        $productQuestion = ProductQuestion::find($id);
        return view("admin.shop.product_questions.show")
            ->with('productQuestion', $productQuestion);

    }


    public function getData($product, $main, $sub, $from_date = '1970-01-01', $to_date = '9999-09-09')
    {
        if ($main == 'all' and $sub == 'all' and $product == 'all')
            $ids = 'all';
        elseif ($main > 0 and $sub == 'all' and $product == 'all')
            $ids = getProductsIdsAccordingForMainCategory($main);
        elseif (
            ($main == 'all' and $sub > 0 and $product == 'all') or
            ($main > 0 and $sub > 0 and $product == 'all'))
            $ids = getProductsIdsAccordingForSubCategory($sub);
        else
            $ids = [$product];
        //            $table->integer('question_products_id')->index('products_images_questions_id');
        //            $table->integer('question_customers_id')->index('idx_questions_customers_id');
        //            $table->string('question_image')->nullable();
        //            $table->text('text', 65535)->nullable();
        //            $table->smallInteger('question_read')->default(0);
        //            $table->integer('sort')->default(1);;
        //            $table->integer('question_status')->default(0);
        $data = DB::table('product_questions')
            ->leftJoin('users', 'product_questions.question_customers_id', 'users.id')
            ->leftJoin('products_description', 'product_questions.question_products_id', 'products_description.product_questions_id')
            ->select('product_questions.*',
                DB::raw("CONCAT(COALESCE(users.first_name,'') , '  ' ,COALESCE(users.last_name,'')) AS user"),
                'products_description.product_questions_name',
                DB::raw("(select count(question_replays.product_question_id) from question_replays where question_replays.product_question_id = product_questions.product_question_id) AS replyes")
            );
        if (!($main == 'all' and $sub == 'all' and $product == 'all'))
            $data = $data->whereIn('product_questions.question_products_id', $ids);
        $data = $data
            ->whereBetween('product_questions.created_at', [$from_date, $to_date])
            ->where('products_description.language_id', '=', 2)
            ->groupBy('product_questions.product_question_id')
            ->orderBy('sort')
            ->get();
        return $data;
    }

    public function filter2(Request $request)
    {
        $from = ($request->from_date == null) ? date('1974-01-01') : date($request->from_date);
        $to = ($request->to_date == null) ? date('9999-01-01') : date($request->to_date);
        $data = $this->getData($request->product, $request->main, $request->sub, $from, $to);
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('manage', 'admin.shop.product_questions.btn.manage')
            ->addColumn('btn_id', 'admin.shop.product_questions.btn.id')
            ->addColumn('btn_sort', 'admin.sortFiles.btn_sort')
            ->rawColumns(['manage', 'btn_sort', 'btn_id'])
            ->make(true);
    }


}
