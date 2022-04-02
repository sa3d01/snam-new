<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends MasterController
{
    public function __construct(Setting $model)
    {
        $this->model = $model;
        $this->route = 'setting';
        $this->json_fields        = ["الاسم" => "name","الوصف"=>"note"];
        $this->module_name         = 'قائمة الاعدادات';
        parent::__construct();
    }

    public function get_setting() {
        $row = $this->model->first();
        return View('admin.setting',compact('row'));
    }

    public function update_setting($id,Request $request) {
        $this->validate($request, $this->validation_func());
        $obj=$this->model->find($id);
        $obj->update($request->all());
        return redirect('admin/'.$this->route.'')->with('updated','تم التعديل بنجاح');
    }
    public function validation_func()
    {
        $therulesarray = [];

        return $therulesarray;
    }

}
