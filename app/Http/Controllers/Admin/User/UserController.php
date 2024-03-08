<?php

namespace App\Http\Controllers\Admin\User;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NewUserRegistered;
use App\Http\Services\Image\ImageService;
use App\Http\Requests\Admin\User\UserRequest;

class UserController extends Controller
{
    protected $logName;


    public function __construct()
    {
        $this->logName = Log::build(['driver' => 'single', 'path' => storage_path('logs/manage-users.log')]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users  = User::where('user_type', 0)
            ->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.user.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request, User $user, ImageService $imageservice)
    {
        $inputs = $request->all();

        // image Upload
        if ($request->hasFile('avatar')) {
            $imageservice->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'user-avatar');
            $result = $imageservice->fitAndSave($request->file('avatar'));
            if ($result === false) {
                return redirect()->route('admin.user.user.create')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['profile_photo_path'] = $result;
        }


        // store data in database
        $inputs['password'] = Hash::make($request->password);
        $inputs['user_type'] = 0;
        $inputs['activation'] = 1;
        $user->create($inputs);


        // set log  message
        Log::stack(['slack', $this->logName])->info('admin create new user', [
            'author' => auth()->user()->full_name,
            'user_email' => $inputs['email'],
            'opration' => 'create',
            'created_at' => Carbon::now(),
        ]);


        $details = [
            'message' => 'یک کاربر جدید در سایت ثبت نام کرد'
        ];
        $adminUser = User::find(1);
        $adminUser->notify(new NewUserRegistered($details));
        return redirect()->route('admin.user.user.index')
            ->with('alert-section-success', 'کاربر جدید شما با موفقیت ثبت شد');
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
    public function edit(User $user)
    {
        return view('admin.user.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user, ImageService $imageservice)
    {
        $inputs = $request->all();

        // image Upload
        if ($request->hasFile('avatar')) {
            if (!empty($user->profile_photo_path)) {
                $imageservice->deleteImage($user->profile_photo_path);
            }
            $imageservice->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'user-avatar');
            $result = $imageservice->fitAndSave($request->file('avatar'));
            if ($result === false) {
                return redirect()->route('admin.user.user.create')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['profile_photo_path'] = $result;
        }

        // update data in database
        $user->update($inputs);

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin update user', [
            'author' => auth()->user()->full_name,
            'user_email' => $inputs['email'],
            'opration' => 'update',
            'data_changed' => '(' . implode(',', $inputs) . ')',
            'updated_at' => Carbon::now(),
        ]);


        return redirect()->route('admin.user.user.index')
            ->with('alert-section-success', 'کاربر با مشخصات ' . ($user->email ?? $user->mobile) . ' با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $result = $user->delete();

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin delete user', [
            'author' => auth()->user()->full_name,
            'user_id' => $user->id,
            'user_email' => $user->email,
            'opration' => 'delete',
            'deleted_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.user.user.index')
            ->with('alert-section-success', ' کاربر با مشخصات ' . ($user->email ?? $user->mobile) . ' با موفقیت حذف شد');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(User $user)
    {
        if ($user->user_type == 0) {
            $user->status = $user->status == 0 ? 1 : 0;
            $result = $user->save();

            if ($result) {
                if ($user->status == 0) {
                    return response()->json(['status' => true, 'checked' => false, 'id' => ($user->email ?? $user->mobile)]);
                } else {
                    return response()->json(['status' => true, 'checked' => true, 'id' => ($user->email ?? $user->mobile)]);
                }
            } else {
                return response()->json(['status' => false]);
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
    public function activation(User $user)
    {
        if ($user->user_type == 0) {
            $user->activation = $user->activation == 0 ? 1 : 0;
            $result = $user->save();

            // set log  message
            Log::stack(['slack', $this->logName])->info('admin change status user', [
                'author' => auth()->user()->full_name,
                'user_id' => $user->id,
                'user_title' => $user->title,
                'opration' => 'delete',
                'deleted_at' => Carbon::now(),
            ]);


            if ($result) {
                if ($user->activation == 0) {
                    return response()->json(['status' => true, 'checked' => false, 'id' => ($user->email ?? $user->mobile)]);
                } else {
                    return response()->json(['status' => true, 'checked' => true, 'id' => ($user->email ?? $user->mobile)]);
                }
            } else {
                return response()->json(['status' => false]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
