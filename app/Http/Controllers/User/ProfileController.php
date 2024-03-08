<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Services\Image\ImageService;
use App\Http\Requests\User\Profile\ProfileUpdateRequest;

class ProfileController extends Controller
{

    protected $logName;


    public function __construct()
    {
        $this->logName = Log::build(['driver' => 'single', 'path' => storage_path('logs/edit-profile-user.log')]);
    }

    public function index()
    {
        $user = auth()->user();
        return view('frontend.Profile.show-profile', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        $provinces = Province::where('status', 1)->get();
        return view('frontend.Profile.edit-profile', compact('user', 'provinces'));
    }



    public function update(ProfileUpdateRequest $request, User $user, ImageService $imageService)
    {
        $inputs = $request->all();

        if (isset($inputs['mobile'])) {
            // filter mobile format
            $inputs['mobile'] = preg_replace('/[^0-9]/', '', $inputs['mobile']);
        }

        ///////////////////////////////////////////////////////////////////////////////

        // image Upload
        if ($request->hasFile('avatar')) {
            if (!empty($user->profile_photo_path)) {
                $imageService->deleteImage($user->profile_photo_path);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'user-avatar');
            $result = $imageService->fitAndSave($request->file('avatar'), 50, 50);

            $userAvatar = $result;
        }

        ///////////////////////////////////////////////////////////////////////////////
        // set user address
        if (isset($inputs['province']) && isset($inputs['city'])) {
            $provinceName = Province::where('id', $inputs['province'])->first('name')->name;
            $cityName = City::where('id', $inputs['city'])->first('name')->name;

            $address = [
                'province' => $inputs['province'],
                'city' => $inputs['city'],
                'province_name' => $provinceName,
                'city_name' => $cityName,
            ];
        }

        // create new user
        $updateUSer = [
            'first_name' => $inputs['first_name'],
            'last_name'  => $inputs['last_name'],
            'address'  => $address,
            'mobile' => $inputs['mobile'],
            'email' => $inputs['email'],
            'national_code' => $inputs['national_code'],
        ];

        // set avatar file path in table
        if ($request->hasFile('avatar')) {
            $updateUSer['profile_photo_path'] = $userAvatar;
        }


        $user->update($updateUSer);


        // set log  message
        Log::stack(['slack', $this->logName])->info('admin update banner', [
            'user_id' => $user['id'],
            'user_email' => $user['email'],
            'opration' => 'update',
            'data_changed' => '(' . implode(',', $updateUSer) . ')',
            'updated_at' => Carbon::now(),
        ]);


        return redirect()->route('user.profile.index')->with('swal-success', ' اطلاعات کاربری شما با موفقیت ویرایش شد');
    }

    public function favorites()
    {
        return view('frontend.Profile.my-favorites');
    }


    public function comments()
    {
        return view('frontend.Profile.my-comments');
    }
}
