<?php

namespace App\Http\Controllers\Admin\Content;

use PSpell\Config;
use Illuminate\Http\Request;
use App\Models\Content\Banner;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Services\Image\ImageService;
use App\Http\Requests\Admin\Content\BannerRequest;
use Carbon\Carbon;

class BannerController extends Controller
{

    protected $logName;


    public function __construct()
    {
        $this->logName = Log::build(['driver' => 'single', 'path' => storage_path('logs/bannder-admin.log')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::orderBy('created_at', 'desc')->paginate(15);
        $positions = Banner::$positions;
        return view('admin.contents.banner.index', compact('banners', 'positions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Banner::$positions;
        return view('admin.contents.banner.create', compact('positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerRequest $request, Banner $banner, ImageService $imageservice)
    {
        $inputs = $request->all();

        // image Upload
        if ($request->hasFile('image')) {
            $imageservice->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'banner');
            $result = $imageservice->save($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.content.banner.create')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }


        // store data in database
        $banner->create($inputs);


        // set log  message
        Log::stack(['slack', $this->logName])->info('admin create banner', [
            'author' => auth()->user()->full_name,
            'banner_title' => $inputs['title'],
            'opration' => 'create',
            'created_at' => Carbon::now(),
        ]);


        return redirect()->route('admin.content.banner.index')
            ->with('alert-section-success', 'بنر جدید شما با موفقیت ثبت شد');
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
    public function edit(Banner $banner)
    {
        $positions = Banner::$positions;
        return view('admin.contents.banner.edit', compact('banner', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, Banner $banner, ImageService $imageservice)
    {

        $inputs = $request->all();


        // update image set and edit
        if ($request->hasFile('image')) {
            if (!empty($banner->image)) {
                $imageservice->deleteImage($banner->image);
            }

            $imageservice->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'banner');
            $result = $imageservice->save($request->file('image'));

            if ($result === false) {
                return redirect()->route('admin.content.banner.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($banner->image)) {
                $image = $banner->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }



        $banner->update($inputs);

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin update banner', [
            'author' => auth()->user()->full_name,
            'banner_title' => $inputs['title'],
            'opration' => 'update',
            'data_changed' => '(' . implode(',', $inputs) . ')',
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.content.banner.index')
            ->with('alert-section-success', 'ویرایش بنر با عنوان   ' . $banner['title'] . ' با موفقیت انجام شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $result = $banner->delete();

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin delete banner', [
            'author' => auth()->user()->full_name,
            'banner_id' => $banner->id,
            'banner_title' => $banner->title,
            'opration' => 'delete',
            'deleted_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.content.banner.index')
            ->with('alert-section-success', ' بنر با عنوان ' . $banner->title . ' با موفقیت حذف شد');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(banner $banner)
    {
        $banner->status = $banner->status == 0 ? 1 : 0;
        $result = $banner->save();

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin change status banner', [
            'author' => auth()->user()->full_name,
            'banner_id' => $banner->id,
            'banner_title' => $banner->title,
            'opration' => 'delete',
            'deleted_at' => Carbon::now(),
        ]);

        if ($result) {
            if ($banner->status == 0) {
                return response()->json(['status' => true, 'checked' => false, 'id' => $banner->title]);
            } else {
                return response()->json(['status' => true, 'checked' => true, 'id' => $banner->title]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
