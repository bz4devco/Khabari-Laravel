<?php

namespace App\Http\Controllers\Admin\Setting;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\CityRequest;

class CityController extends Controller
{

    protected $logName;


    public function __construct()
    {
        $this->logName = Log::build(['driver' => 'single', 'path' => storage_path('logs/city-setting-admin.log')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Province $province)
    {
        $cities = City::where('province_id', $province->id)
            ->orderBy('name', 'asc')->paginate(15);

        return view('admin.setting.city.index', compact('cities', 'province'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Province $province)
    {
        return view('admin.setting.city.create', compact('province'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityRequest $request, Province $province, City $city)
    {
        $inputs = $request->all();
        $inputs['province_id'] = $province->id;

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin create city', [
            'author' => auth()->user()->full_name,
            'city_name' => $inputs['name'],
            'opration' => 'create',
            'created_at' => Carbon::now(),
        ]);

        // store data in database
        $city->create($inputs);
        return redirect()->route('admin.setting.city.index', $province->id)
            ->with('alert-section-success', 'شهرستان جدید با موفقیت ثبت شد');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Province $province, City $city)
    {
        return view('admin.setting.city.edit', compact('province', 'city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CityRequest $request, Province $province, City $city)
    {
        $inputs = $request->all();

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin update city', [
            'author' => auth()->user()->full_name,
            'city_name' => $inputs['name'],
            'opration' => 'update',
            'data_changed' => '(' . implode(',', $inputs) . ')',
            'updated_at' => Carbon::now(),
        ]);


        $city->update($inputs);
        return redirect()->route('admin.setting.city.index', $province->id)
            ->with('alert-section-success', 'ویرایش شهراستان با نام   ' . $city['name'] . ' با موفقیت انجام شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Province $province, City $city)
    {
        $result = $city->delete();

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin delete city', [
            'author' => auth()->user()->full_name,
            'city_id' => $city->id,
            'city_title' => $city->title,
            'opration' => 'delete',
            'deleted_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.setting.city.index', $province->id)
            ->with('alert-section-success', ' شهراستان با نام ' . $city->name . ' با موفقیت حذف شد');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(City $city)
    {
        $city->status = $city->status == 0 ? 1 : 0;
        $result = $city->save();

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin change status city', [
            'author' => auth()->user()->full_name,
            'city_id' => $city->id,
            'city_title' => $city->title,
            'opration' => 'delete',
            'deleted_at' => Carbon::now(),
        ]);

        if ($result) {
            if ($city->status == 0) {
                return response()->json(['status' => true, 'checked' => false, 'id' => $city->name]);
            } else {
                return response()->json(['status' => true, 'checked' => true, 'id' => $city->name]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
