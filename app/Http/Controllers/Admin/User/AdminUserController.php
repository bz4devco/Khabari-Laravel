<?php

namespace App\Http\Controllers\Admin\User;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserRole\Role;
use App\Models\UserRole\Permission;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\Image\ImageService;
use App\Http\Requests\Admin\User\AdminUserRequest;

class AdminUserController extends Controller
{

    protected $logName;


    public function __construct()
    {
        $this->logName = Log::build(['driver' => 'single', 'path' => storage_path('logs/manage-admins.log')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = User::where('user_type', 1)
            ->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.user.admin-user.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.admin-user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminUserRequest $request, User $admin, ImageService $imageservice)
    {
        $inputs = $request->all();

        // image Upload
        if ($request->hasFile('avatar')) {
            $imageservice->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'admin-avatar');
            $result = $imageservice->fitAndSave($request->file('avatar'));
            if ($result === false) {
                return redirect()->route('admin.user.admin-user.create')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['profile_photo_path'] = $result;
        }


        // store data in database
        $inputs['password'] = Hash::make($request->password);
        $inputs['user_type'] = 1;
        $inputs['activation'] = 1;
        $inputs['username'] = 'admin';
        $admin->create($inputs);


        // set log  message
        Log::stack(['slack', $this->logName])->info('admin create new admin', [
            'author' => auth()->user()->full_name,
            'new_admin_email' => $inputs['email'],
            'opration' => 'create',
            'created_at' => Carbon::now(),
        ]);



        return redirect()->route('admin.user.admin-user.index')
            ->with('alert-section-success', 'ادمین جدید شما با موفقیت ثبت شد');
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
    public function edit(User $admin)
    {
        return view('admin.user.admin-user.edit', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function roles(User $admin)
    {
        $roles = Role::where('status', 1)->get();
        return view('admin.user.admin-user.roles', compact('admin', 'roles'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rolesStore(Request $request, User $admin)
    {
        $request->validate([
            'roles' => 'required|exists:roles,id|array'
        ]);

        $inputs = $request->all();

        // store roles in role_user table
        $admin->roles()->sync($request->roles);


        // set log  message
        Log::stack(['slack', $this->logName])->info('manage admin roles', [
            'author' => auth()->user()->full_name,
            'admin_email' => $admin->email,
            'opration' => 'sync',
            'data_changed' => '(' . implode(',', $request->roles) . ')',
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.user.admin-user.index')
            ->with('alert-section-success', 'نقش ادمین با مشخصات ' . ($admin->email ?? $admin->mobile) . ' با موفقیت تخصیص داده شد');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function permissions(User $admin)
    {
        $permissions = Permission::where('status', 1)->get();
        return view('admin.user.admin-user.permissions', compact('admin', 'permissions'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function permissionsStore(Request $request, User $admin)
    {
        $request->validate([
            'permissions' => 'required|exists:permissions,id|array'
        ]);

        $inputs = $request->all();

        // store permissions in permission_user table
        $admin->permissions()->sync($request->permissions);


        // set log  message
        Log::stack(['slack', $this->logName])->info('sync admin permission', [
            'author' => auth()->user()->full_name,
            'admin_email' => $admin->email,
            'opration' => 'sync',
            'data_changed' => '(' . implode(',', $request->permissions) . ')',
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.user.admin-user.index')
            ->with('alert-section-success', 'سطح دسترسی ادمین با مشخصات ' . ($admin->email ?? $admin->mobile) . ' با موفقیت تخصیص داده شد');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUserRequest $request, User $admin, ImageService $imageservice)
    {
        $inputs = $request->all();

        // image Upload
        if ($request->hasFile('avatar')) {
            if (!empty($admin->profile_photo_path)) {
                $imageservice->deleteImage($admin->profile_photo_path);
            }
            $imageservice->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'admin-avatar');
            $result = $imageservice->fitAndSave($request->file('avatar'));
            if ($result === false) {
                return redirect()->route('admin.user.admin-user.create')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['profile_photo_path'] = $result;
        }

        if ($admin->id === 1) {
            $inputs['status'] = 1;
        }
        // store data in database
        $admin->update($inputs);


        // set log  message
        Log::stack(['slack', $this->logName])->info('admin update admins', [
            'author' => auth()->user()->full_name,
            'admin_email' => $admin->email,
            'opration' => 'update',
            'data_changed' => '(' . implode(',', $inputs) . ')',
            'updated_at' => Carbon::now(),
        ]);


        return redirect()->route('admin.user.admin-user.index')
            ->with('alert-section-success', 'ادمین با مشخصات ' . ($admin->email ?? $admin->mobile) . ' با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $admin)
    {
        if ($admin->id !== 1 && $admin->user_type == 1) {
            $result = $admin->delete();

            // set log  message
            Log::stack(['slack', $this->logName])->info('admin delete banner', [
                'author' => auth()->user()->full_name,
                'admin_id' => $admin->id,
                'admin_email' => $admin->email,
                'opration' => 'delete',
                'deleted_at' => Carbon::now(),
            ]);


            return redirect()->route('admin.user.admin-user.index')
                ->with('alert-section-success', 'ادمین با مشخصات' . ($admin->email ?? $admin->mobile) . ' با موفقیت حذف شد');
        }
        return redirect()->route('admin.user.admin-user.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(User $admin)
    {
        if ($admin->user_type == 1 && $admin->id !== 1) {
            $admin->status = $admin->status == 0 ? 1 : 0;
            $result = $admin->save();


            // set log  message
            Log::stack(['slack', $this->logName])->info('admin change status admins', [
                'author' => auth()->user()->full_name,
                'admin_if' => $admin->id,
                'admin_emial' => $admin->email,
                'opration' => 'delete',
                'deleted_at' => Carbon::now(),
            ]);

            if ($result) {
                if ($admin->status == 0) {
                    return response()->json(['status' => true, 'checked' => false, 'id' => ($admin->email ?? $admin->mobile)]);
                } else {
                    return response()->json(['status' => true, 'checked' => true, 'id' => ($admin->email ?? $admin->mobile)]);
                }
            } else {
                return response()->json(['status' => false]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
