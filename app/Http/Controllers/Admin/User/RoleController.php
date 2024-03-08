<?php

namespace App\Http\Controllers\Admin\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\UserRole\Role;
use App\Models\UserRole\Permission;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\RoleRequest;

class RoleController extends Controller
{

    protected $logName;


    public function __construct()
    {
        $this->logName = Log::build(['driver' => 'single', 'path' => storage_path('logs/roles-admin.log')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles  = Role::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.user.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::where('status', 1)->get();
        return view('admin.user.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $inputs = $request->all();

        $role = Role::create($inputs);
        $inputs['permissions'] = $inputs['permissions'] ?? [];
        $role->permissions()->sync($inputs['permissions']);

        // set log  message
        Log::stack(['slack', $this->logName])->info('sync permission to role', [
            'author' => auth()->user()->full_name,
            'permission_title' => $inputs['title'],
            'opration' => 'create',
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.user.role.index')
            ->with('alert-section-success', 'نقش جدید شما با موفقیت ثبت شد');
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
    public function edit(Role $role)
    {
        return view('admin.user.role.edit', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function permissionForm(Role $role)
    {
        $permissions = Permission::where('status', 1)->get();
        return view('admin.user.role.permission-form', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $inputs = $request->all();
        $role->update($inputs);

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin update roles', [
            'author' => auth()->user()->full_name,
            'role_title' => $inputs['title'],
            'opration' => 'update',
            'data_changed' => '(' . implode(',', $inputs) . ')',
            'updated_at' => Carbon::now(),
        ]);


        return redirect()->route('admin.user.role.index')
            ->with('alert-section-success', 'نقش با عنوان ' . $role->title . ' با موفقیت ویرایش شد');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function permissionUpadte(RoleRequest $request, Role $role)
    {
        $inputs = $request->all();
        $inputs['permissions'] = $inputs['permissions'] ?? [];
        $role->permissions()->sync($inputs['permissions']);


        // set log  message
        Log::stack(['slack', $this->logName])->info('update sync  permissions for role', [
            'author' => auth()->user()->full_name,
            'role_id' => $role->id,
            'role_title' => $role->title,
            'opration' => 'update',
            'data_changed' => '(' . implode(',', $inputs) . ')',
            'deleted_at' => Carbon::now(),
        ]);


        return redirect()->route('admin.user.role.index')
            ->with('alert-section-success', 'دسترسی های نقش  ' . $role->title . ' با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $result = $role->delete();

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin delete role', [
            'author' => auth()->user()->full_name,
            'role_id' => $role->id,
            'role_title' => $role->title,
            'opration' => 'delete',
            'deleted_at' => Carbon::now(),
        ]);


        return redirect()->route('admin.user.role.index')
            ->with('alert-section-success', 'نقش با عنوان ' . $role->title . ' با موفقیت حذف شد');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Role $role)
    {
        $role->status = $role->status == 0 ? 1 : 0;
        $result = $role->save();

        // set log  message
        Log::stack(['slack', $this->logName])->info('admin change status role', [
            'author' => auth()->user()->full_name,
            'role_id' => $role->id,
            'role_title' => $role->title,
            'opration' => 'delete',
            'deleted_at' => Carbon::now(),
        ]);


        if ($result) {
            if ($role->status == 0) {
                return response()->json(['status' => true, 'checked' => false, 'id' => $role->title]);
            } else {
                return response()->json(['status' => true, 'checked' => true, 'id' => $role->title]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
