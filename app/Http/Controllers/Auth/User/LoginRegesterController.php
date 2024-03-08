<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\User;
use App\Models\Setting;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\Image\ImageService;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Requests\User\Profile\RegisterRequest;
use Illuminate\Foundation\Auth\ThrottlesLogins;

use App\Models\City;

class LoginRegesterController extends Controller
{

    use ThrottlesLogins;

    
    public function registerForm()
    {
        if (!Auth::check()) {
            $provinces = Province::where('status', 1)->orderBy('name', 'asc')->get();

            return view('frontend.Profile.register-form', compact('provinces'));
        } else {
            return redirect()->route('user.home');
        }
    }


    public function register(RegisterRequest $request, User $user, ImageService $imageService)
    {
        $inputs = $request->all();
        if (isset($inputs['mobile'])) {
            // filter mobile format
            $inputs['mobile'] = preg_replace('/[^0-9]/', '', $inputs['mobile']);

            $user = User::where('mobile', $inputs['mobile'])->first();
            if (empty($user)) {
                $newUser['mobile'] = $inputs['mobile'];
            } else {
                $checkNoAdmin = $user->user_type == 1 ? true : false;
                if ($checkNoAdmin) {
                    return redirect()->route('user.auth.register-form');
                }
            }
        }

        if (isset($inputs['email']) && filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $inputs['email'])->first();
            if (empty($user)) {
                $newUser['email'] = $inputs['email'];
            } else {
                $checkNoAdmin = $user->user_type == 1 ? true : false;
                if ($checkNoAdmin) {
                    return redirect()->route('user.auth.register-form');
                }
            }
        }

        ///////////////////////////////////////////////////////////////////////////////

        // image Upload
        if ($request->hasFile('avatar')) {
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
        $newUSer = [
            'first_name' => $inputs['first_name'],
            'last_name'  => $inputs['last_name'],
            'address'  => $address,
            'mobile' => $inputs['mobile'],
            'email' => $inputs['email'],
            'gender' => $inputs['gender'],
            'national_code' => $inputs['national_code'],
            'username' => $inputs['username'],
            'password' => Hash::make($inputs['password']),
            'activation' => 1,
            'user_type' => 0,
            'status' => 1,
        ];


        if ($request->hasFile('avatar')) {
            $newUSer['profile_photo_path'] = $userAvatar;
        }

        if (isset($request->service_status)) {
            $newUSer['service_status'] = $inputs['service_status'];
        }


        DB::transaction(function () use ($inputs, $newUSer) {

            $user = User::create($newUSer);

            ///////////////////////////////////////////////////////////////////////////////////////
            // sned welcome email for registered user
            if ($user) {
                $webTitle = Setting::where('status', 1)->orderBy('id', 'asc')->first('title')->title ?? 'وبسایت خبری';

                $emailService = new EmailService();
                $details = [
                    'title' => ' ثبت نام در وبسایت ' . $webTitle,
                    'name' =>  $user->full_name,
                    'body' => "به وبسایت ما خوش آمدید، با وبسایت ما می توانید تمامی اخبار روز کشور با خبر شود. <br/> نام کاربری: " . $inputs['username'] . "<br> رمزعبود :" . $inputs['password']
                ];
                $emailService->setDetails($details);
                $emailService->setFrom('noreply@example.com', $webTitle);
                $emailService->setSubject('ثبت نام در وبسایت' . $webTitle);
                $emailService->setTo($inputs['email']);

                $messageService = new MessageService($emailService);
            }

            $messageService->send();

            Auth::loginUsingId($user->id);
        });

        return redirect()->route('user.home')->with('swal-success', 'ثبت نام شما در وبسایت با موفقیت انجام شد');
    }




    public function login()
    {
        if (request('username')) {
            if (preg_match('/^[0-9a-zA-Z]+$/u', request('username'))) {
                if (User::where('username', request('username'))->first()) {
                    if (request('password')) {
                        if ($this->attempLogin()) {
                            return $this->sendSuccessResponse();
                        }else{
                            return response()->json(['incorrectLoginInfo' => 'نام کاربری و یا کلمه عبور صحیح نمی باشد']);
                        }
                    } else {
                        return response()->json(['password' => 'لطفاً فیلد رمز عبور را وارد نمایید']);
                    }
                } else {
                    return response()->json(['username' => 'نام کاربری نا معتبر می باشد']);
                }
            } else {
                return response()->json(['username' => 'نام کاربری نا معتبر می باشد']);
            }
        } else {
            return response()->json(['username' => 'لطفاً فیلد نام کاربری را وارد نمایید']);
        }
    }


    protected function attempLogin()
    {
        $credentials['username'] = request('username');
        $credentials['password'] = request('password');
        return  Auth::attempt($credentials, request('remember'));
    }


    protected function sendSuccessResponse()
    {
        session()->regenerate();
        return response()->json(['status' => true]);
    }




    public function logout()
    {
        session()->invalidate();
        Auth::logout();
        return redirect()->route('user.home');
    }





    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCities(Province $province)
    {
        $cities = $province->cities;
        if ($cities != null) {
            return response()->json(['status' => true, 'cities' => $cities]);
        } else {
            return response()->json(['status' => false, 'cities' => null]);
        }
    }
}
