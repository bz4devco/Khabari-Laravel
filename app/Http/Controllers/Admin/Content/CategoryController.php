<?php

namespace App\Http\Controllers\Admin\Content;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Content\ReportCategory;
use App\Http\Services\Image\ImageService;
use App\Http\Requests\Admin\Content\ReportCategoryRequest;

class CategoryController extends Controller
{

    protected $logName;


    public function __construct()
    {
        $this->logName = Log::build(['driver' => 'single', 'path' => storage_path('logs/report-category-admin.log')]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $reportCategorys  = ReportCategory::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.contents.category.index', compact('reportCategorys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.contents.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReportCategoryRequest $request, ReportCategory $reportCategory, ImageService $imageservice)
    {
        $inputs = $request->all();

        // image Upload
        if ($request->hasFile('image')) {
            $imageservice->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'report-category');
            $result = $imageservice->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.content.category.create')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }


        // store data in database
        $reportCategory->create($inputs);

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin create report category', [
            'author' => auth()->user()->full_name,
            'category_name' => $inputs['name'],
            'opration' => 'create',
            'created_at' => Carbon::now(),
        ]);



        return redirect()->route('admin.content.reports.category.index')
            ->with('alert-section-success', 'دسته بندی جدید شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportCategory $reportCategory)
    {
        return view('admin.contents.category.edit', compact('reportCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReportCategoryRequest $request, ReportCategory $reportCategory, ImageService $imageservice)
    {

        $inputs = $request->all();


        // update image set and edit
        if ($request->hasFile('image')) {
            if (!empty($reportCategory)) {
                $imageservice->deleteDirectoryAndFiles($reportCategory->image['directory']);
            }
            $imageservice->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'report-category');
            $result = $imageservice->createIndexAndSave($request->file('image'));

            if ($result === false) {
                return redirect()->route('admin.content.category.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($reportCategory->image)) {
                $image = $reportCategory->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }



        $reportCategory->update($inputs);

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin update report category', [
            'author' => auth()->user()->full_name,
            'category_name' => $inputs['name'],
            'opration' => 'update',
            'data_changed' => '(' . implode(',', $inputs) . ')',
            'updated_at' => Carbon::now(),
        ]);


        return redirect()->route('admin.content.reports.category.index')
            ->with('alert-section-success', 'ویرایش دسته بندی با نام   ' . $reportCategory['name'] . ' با موفقیت انجام شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportCategory $reportCategory)
    {
        $result = $reportCategory->delete();


        // set log  message
        Log::stack(['slack', $this->logName])->info('admin delete report category', [
            'author' => auth()->user()->full_name,
            'category_id' => $reportCategory->id,
            'category_name' => $reportCategory->name,
            'opration' => 'delete',
            'deleted_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.content.reports.category.index')
            ->with('alert-section-success', ' دسته بندی با نام ' . $reportCategory->name . ' با موفقیت حذف شد');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(ReportCategory $reportCategory)
    {
        $reportCategory->status = $reportCategory->status == 0 ? 1 : 0;
        $result = $reportCategory->save();

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin change status banner', [
            'author' => auth()->user()->full_name,
            'category_id' => $reportCategory->id,
            'category_name' => $reportCategory->name,
            'opration' => 'delete',
            'deleted_at' => Carbon::now(),
        ]);


        if ($result) {
            if ($reportCategory->status == 0) {
                return response()->json(['status' => true, 'checked' => false, 'id' => $reportCategory->name]);
            } else {
                return response()->json(['status' => true, 'checked' => true, 'id' => $reportCategory->name]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
