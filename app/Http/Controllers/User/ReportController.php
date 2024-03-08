<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Content\Report;
use App\Models\Content\ReportCategory;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(ReportCategory $reportCategory, Request $request)
    {
        foreach ($reportCategory as $reportCategoryItem) {
            if (!isset($reportCategory->name)) {
                $reportCategory = null;
            }
        }

        $search = isset($request->search) ? checkRequest($request->search) : null;

        $reports = Report::activeReportsWithCategory($reportCategory, $search)->orderBy('created_at', 'desc')->paginate(8);

        return view('frontend.report.index', compact('reportCategory', 'reports'));
    }

    public function detail(Report $report)
    {
        
        $report->visit_counter = $report->visit_counter + 1;
        $report->save();

        $tags = $report->tag ? explode(',' ,$report->tag) : null;
        

        return view('frontend.report.detail',  compact('report', 'tags'));
    }
   

    public function comment(Request $request,Report $report)
    {
        $request->validate([
            'body' => 'required|min:2|max:250|regex:/^[الف-یa-zA-Z0-9\-۰-۹آء-ي.,،:() ]+$/u'
        ]);

        if(Auth::check() && auth()->user()->user_type == 0 ){
            $inputs = [
                'body' => $request->body,
                'author_id' => Auth::check() ? (auth()->user()->user_type == 0 ? auth()->user()->id :  0) : 0,
                'commentable_id'=> $report->id,
                'commentable_type' => Report::class,
                'status' => 1
            ];
    
            $report->comments()->create($inputs);
        }
        else{

            $inputs = [
                'body' => $request->body,
                'commentable_id'=> $report->id,
                'commentable_type' => Report::class,
                'status' => 1
            ];
    
            $report->guestComments()->create($inputs);
        }


        return redirect()->back()->with('swal-success', 'نظر شما با موفقیت ثبت شد');

    }


    public function addToFavorite(Report $report){
        if (Auth::check() && auth()->user()->user_type == 0) {
            $report->user()->toggle([Auth::user()->id]);

            if ($report->user->contains(Auth::user()->id)) {
                return redirect()->back()->with('swal-success', 'خبر با موفقیت به لیست علاقه مندی ها اضافه شد');
            } else {
                return redirect()->back()->with('swal-success', 'خبر با موفقیت از لیست علاقه مندی های شما حذف شد');
            }
        } else {
            return redirect()->back()->with('swal-error', 'کاربر گرامی جهت افزودن خبر به علاقه مندی های خود ابتدا وارد حساب کاربری خود شود');
        }
    }
}
