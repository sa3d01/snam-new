<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends MasterController
{
    public function __construct(Page $model)
    {
        $this->model = $model;
        $this->route = 'page';
        $this->module_name         = 'قائمة الصفحة';
        $this->single_module_name  = 'صفحة';
        parent::__construct();
    }
    public function editPage($name)
    {
        $page=Page::where('name',$name)->first();
        return View('admin.page.edit',compact('page'));
    }
    public function uploadImage($image)
    {
        $filename = Str::random(10) . '.' . $image->getClientOriginalExtension();
        $image->move('images/page/', $filename);
        return asset('images/page/').'/'.$filename;
    }
    public function uploadImages()
    {
        $new_images=[];
        for ($i=1;$i<=15;$i++)
        {
            if (\request()->hasFile('image_'.$i)){
                $filename=$this->uploadImage(\request()->file('image_'.$i));
                $new_images[]=$filename;
            }
        }
        return $new_images;
    }
    public function update($id, Request $request) {
        $page=$this->model->find($id);
        $data=$request->all();

        $old_images=json_decode($page->images);
        $new_images=$this->uploadImages();

        $data['images'] = array_merge($old_images,$new_images);

//        if ($request->images){
//            foreach ($request->images as $image){
//                if (is_file($image)) {
//                    if ($image->getSize() > 4194304){
//                        return redirect()->back()->withErrors(['حجم الصورة كبير جدا..']);
//                    }
//                    $filename = Str::random(10) . '.' . $image->getClientOriginalExtension();
//                    $image->move('images/page/', $filename);
//                    $local_name=asset('images/page/').'/'.$filename;
//                }else {
//                    $local_name = $image;
//                }
//                $images[]=$local_name;
//            }
//            $data['images'] = $images;
//        }

        $page->update($data);
        return redirect('admin/page/'.$page->name)->with('updated','تم التعديل بنجاح');
    }



}
