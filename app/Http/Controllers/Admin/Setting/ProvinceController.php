<?php

namespace App\Http\Controllers\Admin\Setting;

use Carbon\Carbon;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\ProvinceRequest;

class ProvinceController extends Controller
{

    protected $logName;


    public function __construct()
    {
        $this->logName = Log::build(['driver' => 'single', 'path' => storage_path('logs/province-setting-admin.log')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinces = Province::orderBy('name', 'asc')->paginate(15);

        return view('admin.setting.province.index', compact('provinces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.province.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProvinceRequest $request, Province $province)
    {
        $inputs = $request->all();

        // store data in database
        $province->create($inputs);

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin create province', [
            'author' => auth()->user()->full_name,
            'province_name' => $inputs['name'],
            'opration' => 'create',
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.setting.province.index')
            ->with('alert-section-success', 'استان جدید با موفقیت ثبت شد');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Province $province)
    {
        return view('admin.setting.province.edit', compact('province'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProvinceRequest $request, Province $province)
    {
        $inputs = $request->all();

        $province->update($inputs);

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin update province', [
            'author' => auth()->user()->full_name,
            'province_name' => $inputs['name'],
            'opration' => 'update',
            'data_changed' => '(' . implode(',', $inputs) . ')',
            'updated_at' => Carbon::now(),
        ]);


        return redirect()->route('admin.setting.province.index')
            ->with('alert-section-success', 'ویرایش استان با نام   ' . $province['name'] . ' با موفقیت انجام شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Province $province)
    {
        $result = $province->delete();

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin delete banner', [
            'author' => auth()->user()->full_name,
            'province_id' => $province->id,
            'province_name' => $province->name,
            'opration' => 'delete',
            'deleted_at' => Carbon::now(),
        ]);


        return redirect()->route('admin.setting.province.index')
            ->with('alert-section-success', ' استان با نام ' . $province->name . ' با موفقیت حذف شد');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Province $province)
    {
        $province->status = $province->status == 0 ? 1 : 0;
        $result = $province->save();

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin change status province', [
            'author' => auth()->user()->full_name,
            'province_id' => $province->id,
            'province_name' => $province->name,
            'opration' => 'delete',
            'deleted_at' => Carbon::now(),
        ]);

        if ($result) {
            if ($province->status == 0) {
                return response()->json(['status' => true, 'checked' => false, 'id' => $province->name]);
            } else {
                return response()->json(['status' => true, 'checked' => true, 'id' => $province->name]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
