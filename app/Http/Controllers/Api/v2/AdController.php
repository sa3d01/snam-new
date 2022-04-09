<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Api\MasterController;
use App\Models\Ad;
use App\Models\Chat;
use App\Models\City;
use App\Models\Favourite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Validator;
use App\Http\Resources\AdHomeResource;

class AdController extends MasterController
{
    public function __construct(Ad $model)
    {
        $this->model = $model;
        $this->route = 'ad';
        parent::__construct();
    }
    public function index(Request $request)
    {
        $rows_q=Ad::query();
        if ($request['category_id']){
            $rows_q=$rows_q->where('category_id',$request['category_id']);
        }
        if ($request['city_id']){
            if (City::where('id',$request['city_id'])->value('type')=='district'){
                $cities_ids=City::where('district_id',$request['city_id'])->pluck('id');
                $rows_q=$rows_q->whereIn('city_id',$cities_ids);
            }else{
                $rows_q=$rows_q->where('city_id',$request['city_id']);
            }
        }
        if ($request['title']){
            $rows_q=$rows_q->where('title','LIKE','%'.$request['title'].'%');
        }
        $rows=$rows_q->latest()->paginate(10);
        return AdHomeResource::collection($rows);
    }

    public function getMovVideos()
    {
//        $ads=Ad::where('videos','!=',null)->get();

//        foreach ($ads as $ad){
//            $ad_videos=[];
//            foreach ($ad->videos as $video){
//                $info = pathinfo($video);
//                if ($info['extension']=='mov' || $info['extension']=='MOV'){
//                    $new_video= $this->replace_extension($video,'mp4');
//                    try{
//                        rename($video,$new_video);
//                    }catch (\Exception $e){
//
//                    }
//                    $ad_videos[]="https://snam.sa/".$new_video;
//                }else{
//                    $ad_videos[]=$video;
//                }
//            }
//            $ad->update([
//                'videos'=>$ad_videos
//            ]);
//        }
//        $iterator = new \GlobIterator('images/ads'. '/*WD7BmJ893I.MOV', \FilesystemIterator::KEY_AS_FILENAME);
        $iterator = new \GlobIterator('images/ads'. '/*.MOV', \FilesystemIterator::KEY_AS_FILENAME);
        $array = iterator_to_array($iterator);
        foreach ($array as $video){
            $new_video= $this->replace_extension($video,'mp4');
            rename($video,$new_video);
        }
    }
    function replace_extension($filename, $new_extension) {
        $info = pathinfo($filename);
        return ($info['dirname'] ? $info['dirname'] . DIRECTORY_SEPARATOR : '')
            . $info['filename']
            . '.'
            . $new_extension;
    }
    public function execute()
    {
        $ads=Ad::latest()->get();
        foreach ($ads as $ad){
            $ad_images=$ad->images;
            $ad_videos=$ad->videos;
            $new_images=null;
            $new_videos=null;
            if (is_array($ad_images)){
                $new_images=[];
                foreach ($ad_images as $image){
                    $new_images[] = substr_replace($image, "https://admin.snam.sa/",0,26);
                }
            }
            if (is_array($ad_videos)){
                $new_videos=[];
                foreach ($ad_videos as $video){
                    $new_videos[] = substr_replace($video, "https://admin.snam.sa/",0,26);
                }
            }
            $ad->update([
                'images'=>$new_images,
                'videos'=>$new_videos,
            ]);
        }
        return response()->json(['done'=>200]);

    }

    public function getUsedImages()
    {
        $user_ids=User::pluck('id');
        $ads_images=Ad::whereIn('user_id',$user_ids)->pluck('images');
        $used_images = Arr::flatten($ads_images);

        $iterator_jpg = new \GlobIterator('images/ads'. '/*.jpg', \FilesystemIterator::KEY_AS_FILENAME);
        $iterator_jpeg = new \GlobIterator('images/ads'. '/*.jpeg', \FilesystemIterator::KEY_AS_FILENAME);
        $iterator_png = new \GlobIterator('images/ads'. '/*.png', \FilesystemIterator::KEY_AS_FILENAME);
        $array_jpg = iterator_to_array($iterator_jpg);
        $array_jpeg = iterator_to_array($iterator_jpeg);
        $array_png = iterator_to_array($iterator_png);
        echo "used_images ".count($used_images);
        return $array_jpeg;
    }

}
