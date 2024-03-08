<?php

namespace App\Http\Controllers\Admin\Content;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Content\Report;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Content\ReportCategory;
use App\Http\Services\Image\ImageService;
use App\Http\Requests\Admin\Content\ReportRequest;

class ReportController extends Controller
{

    protected $logName;


    public function __construct()
    {
        $this->logName = Log::build(['driver' => 'single', 'path' => storage_path('logs/report-admin.log')]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!is_null($request)) {
            $sreach = checkRequest($request->search) ?? null;
            if ($sreach) {
                $reports = Report::where('title', 'LIKE', "%" . $sreach . "%")->paginate(15);
            } else {
                $reports = Report::orderBy('created_at', 'desc')->paginate(15);
            }
        } else {
            $reports = Report::orderBy('created_at', 'desc')->paginate(15);
        }
        return view('admin.contents.report.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ReportCategory $reportCategory)
    {
        $categorys = $reportCategory->all();
        return view('admin.contents.report.create', compact('categorys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReportRequest $request, Report $report, ImageService $imageservice)
    {

        $inputs = $request->all();

        // date fixed
        $realTimestampStart = substr($request->new_date, 0, 10);
        $inputs['new_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);


        // image Upload
        if ($request->hasFile('image')) {
            $imageservice->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'report');
            $result = $imageservice->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.content.reports.create')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }

        // store data in database
        $inputs['author_id'] = 1;
        $inputs['visit_counter'] = 0;
        $inputs['tag'] = $inputs['tags'];

        $report->create($inputs);


        // set log  message
        Log::stack(['slack', $this->logName])->info('admin create report', [
            'author' => auth()->user()->full_name,
            'report_title' => $inputs['title'],
            'opration' => 'create',
            'created_at' => Carbon::now(),
        ]);



        return redirect()->route('admin.content.reports.index')
            ->with('alert-section-success', 'خبر جدید شما با موفقیت ثبت شد');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadImagesCkeditor(Request $request, ImageService $imageService)
    {
        $request->validate([
            'upload' => 'sometimes|required|max:10240|image|mimes:png,jpg,jpeg,gif,ico,svg,webp'
        ]);
        // image Upload
        if ($request->hasFile('upload')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'report-body');
            $url = $imageService->save($request->file('upload'));
            $url = str_replace('\\', '/', $url);
            $url = asset($url);

            return "<script>window.parent.CKEDITOR.tools.callFunction(1, '{$url}' , '')</script>";
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report, ReportCategory $reportCategory)
    {
        $categorys = $reportCategory->all();
        $timestampStart = strtotime($report['new_date']);
        $report['new_date'] = $timestampStart . '000';
        return view('admin.contents.reports.edit', compact('report', 'categorys'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReportRequest $request, Report $report, ImageService $imageservice)
    {

        $inputs = $request->all();
        // date fixed
        $realTimestampStart = substr($request->new_date, 0, 10);
        $inputs['new_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        // update image set and edit
        if ($request->hasFile('image')) {
            if (!empty($report)) {
                $imageservice->deleteDirectoryAndFiles($report->image['directory']);
            }
            $imageservice->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'report');
            $result = $imageservice->createIndexAndSave($request->file('image'));

            if ($result === false) {
                return redirect()->route('admin.content.reports.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($report->image)) {
                $image = $report->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }

        $report->update($inputs);

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin update report', [
            'author' => auth()->user()->full_name,
            'report_title' => $inputs['title'],
            'opration' => 'update',
            'data_changed' => '(' . implode(',', $inputs) . ')',
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.content.reports.index')
            ->with('alert-section-success', 'ویرایش خبر با عنوان   ' . $report['title'] . ' با موفقیت انجام شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        $result = $report->delete();
        return redirect()->route('admin.content.reports.index')
            ->with('alert-section-success', ' خبر با عنوان ' . $report->title . ' با موفقیت حذف شد');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Report $report)
    {
        $report->status = $report->status == 0 ? 1 : 0;
        $result = $report->save();

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin change status report', [
            'author' => auth()->user()->full_name,
            'report_id' => $report->id,
            'report_title' => $report->title,
            'opration' => 'delete',
            'value_set' => $report->status,
            'deleted_at' => Carbon::now(),
        ]);

        if ($result) {
            if ($report->status == 0) {
                return response()->json(['status' => true, 'checked' => false, 'id' => $report->title]);
            } else {
                return response()->json(['status' => true, 'checked' => true, 'id' => $report->title]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function commentable(Report $report)
    {
        $report->commentable = $report->commentable == 0 ? 1 : 0;
        $result = $report->save();

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin change commentable report', [
            'author' => auth()->user()->full_name,
            'report_id' => $report->id,
            'report_title' => $report->title,
            'opration' => 'delete',
            'value_set' => $report->commentable,
            'deleted_at' => Carbon::now(),
        ]);

        if ($result) {
            if ($report->commentable == 0) {
                return response()->json(['commentable' => true, 'checked' => false, 'id' => $report->title]);
            } else {
                return response()->json(['commentable' => true, 'checked' => true, 'id' => $report->title]);
            }
        } else {
            return response()->json(['commentable' => false]);
        }
    }
}
