<?php

namespace App\Http\Controllers\Admin\Setting;

use Carbon\Carbon;
use App\Models\Setting;
use Illuminate\Http\Request;
use Database\Seeders\SettingSeeder;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Services\Image\ImageService;
use App\Http\Requests\Admin\Setting\SettingRequest;

class SettingController extends Controller
{


    protected $logName;


    public function __construct()
    {
        $this->logName = Log::build(['driver' => 'single', 'path' => storage_path('logs/setting-admin.log')]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::orderBy('id', 'desc')->paginate(15);

        return view('admin.setting.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return redirect()->route('admin.setting.index')
            ->with('alert-section-success', 'تنظیم جدید با تنظیمات پایه ایجاد شد')
            ->with('alert-section-info', 'توجه : جهت تکمیل تنظیمات تکمیلی به ویرایش تنظیمات جدید ایجاد شده مراجعه نمایید.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        return view('admin.setting.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SettingRequest $request, Setting $setting, ImageService $imageservice)
    {
        $inputs = $request->all();



        // update image of logo
        if ($request->hasFile('logo')) {
            if (!empty($setting->logo)) {
                $imageservice->deleteImage($setting->logo);
            }
            $imageservice->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'setting');
            $imageservice->setImageName('logo');
            $result = $imageservice->save($request->file('logo'));

            if ($result === false) {
                return redirect()->route('admin.setting.edit')->with('swal-error', 'آپلود لوگو با خطا مواجه شد');
            }
            $inputs['logo'] = $result;
        }

        // update image of icon
        if ($request->hasFile('icon')) {
            // reset properties image service
            $imageservice->resetProperties();

            if (!empty($setting->icon)) {
                $imageservice->deleteImage($setting->icon);
            }
            $imageservice->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'setting');
            $imageservice->setImageName('icon');
            $result = $imageservice->save($request->file('icon'));

            if ($result === false) {
                return redirect()->route('admin.setting.edit', $setting->id)->with('swal-error', 'آپلود آیکون با خطا مواجه شد');
            }
            $inputs['icon'] = $result;
        }

        $setting->update($inputs);

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin update setting', [
            'author' => auth()->user()->full_name,
            'setting_title' => $inputs['title'],
            'opration' => 'update',
            'data_changed' => '(' . implode(',', $inputs) . ')',
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.setting.index')
            ->with('alert-section-success', 'ویرایش تنظیمات شماره   ' . $setting['id'] . ' با موفقیت انجام شد');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editIndexPage(Setting $setting)
    {
        $setting = $setting->first(['id', 'title', 'index_page']);

        return view('admin.setting.edit-index-page', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateIndexPage(Request $request, Setting $setting)
    {

        $inputs['index_page'] = $request->index_page;

        $setting->update($inputs);
        return redirect()->route('admin.setting.index')
            ->with('alert-section-success', 'ویرایش نمایش صفحه اصلی برای تنظیمات شماره   ' . $setting['id'] . ' با موفقیت انجام شد');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        $result = $setting->delete();

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin delete setting', [
            'author' => auth()->user()->full_name,
            'setting_id' => $setting->id,
            'setting_title' => $setting->title,
            'opration' => 'delete',
            'deleted_at' => Carbon::now(),
        ]);


        return redirect()->route('admin.setting.index')
            ->with('alert-section-success', 'تنظیمت شماره ' . $setting->id . ' با موفقیت حذف شد');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Setting $setting)
    {
        $setting->status = $setting->status == 0 ? 1 : 0;
        $result = $setting->save();

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin change status setting', [
            'author' => auth()->user()->full_name,
            'setting_id' => $setting->id,
            'setting_title' => $setting->title,
            'opration' => 'delete',
            'deleted_at' => Carbon::now(),
        ]);

        if ($result) {
            if ($setting->status == 0) {
                return response()->json(['status' => true, 'checked' => false, 'id' => $setting->id]);
            } else {
                return response()->json(['status' => true, 'checked' => true, 'id' => $setting->id]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
