<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\AdminRole;
use App\Models\Role;
use App\Models\RolePermission;
//use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminController extends MasterController
{
    public function __construct(Admin $model)
    {
        $this->model = $model;
        $this->route = 'admin';
        $this->module_name = 'قائمة الادارة';
        $this->single_module_name = 'مدير';
        $this->index_fields = ['الاسم' => 'name', 'البريد الإلكترونى' => 'email', 'رقم الجوال' => 'mobile'];
        $this->create_fields = ['الاسم' => 'name', 'البريد الإلكترونى' => 'email', 'رقم الجوال' => 'mobile'];
        $this->update_fields = ['الاسم' => 'name', 'البريد الإلكترونى' => 'email', 'رقم الجوال' => 'mobile'];
        parent::__construct();
    }

    public function home()
    {
        $rows = Admin::all();
        return view('admin.admin.index', compact('rows'));
    }

    public function dashboard()
    {
        return view($this->route . '.index');
    }

    public function edit_profile()
    {
        $row = Auth::user();
        return View($this->route . '.profile', compact('row'));
    }

    public function update_profile($id, Request $request)
    {
        $this->validate($request, $this->validation_func(2, $id));
        $this->model->find($id)->update($request->all());
        return redirect('admin/' . $this->route . '')->with('updated', 'تم التعديل بنجاح');
    }

    public function validation_func($method, $id = null)
    {
        if ($method == 1) // POST Case
            return ['name' => 'required', 'mobile' => 'required|unique:admins', 'email' => 'email|max:255|unique:admins', 'image' => 'mimes:png,jpg,jpeg', 'password' => 'required|min:6'];
        return ['name' => 'required', 'mobile' => 'required|unique:admins,mobile,' . $id, 'email' => 'email|max:255|unique:admins,email,' . $id, 'image' => 'mimes:png,jpg,jpeg', 'password' => 'min:6'];
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validation_func(1));
        $obj = $this->model->create($request->all());
        if ($request->role) {
            $role = new AdminRole();
            $role->admin_id = $obj->id;
            $role->role_id = $request->role;
            $role->save();
        }
        return redirect('admin/admin')->with('created', 'تمت الاضافة بنجاح');
    }

    public function edit($id)
    {
        $row = $this->model->find($id);
        $roles = Role::all();
        $role_id = AdminRole::where('admin_id', $row->id)->pluck('role_id');
        $permissions = RolePermission::whereIn('role_id', $role_id)->get();
        return View('admin.' . $this->route . '.edit', compact('row', 'roles', 'permissions'));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, $this->validation_func(2, $id));
        $obj = $this->model->find($id);
        $obj->update($request->all());
        if ($request->role) {
            AdminRole::where('admin_id', $id)->update(['role_id' => $request->role]);
        }
        return redirect('admin/' . $this->route . '')->with('updated', 'تم التعديل بنجاح');
    }
}
