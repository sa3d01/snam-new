<?php

namespace App\Http\Resources;

use App\Models\Chat;
use App\Models\Favourite;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AdHomeResource extends JsonResource
{
    public function toArray($request)
    {
        $arr['id'] = (int)$this->id;
        $arr['title'] = $this->title;
        if ($this->images==null){
            $arr['image']='https://i.imgur.com/NBNktLX.png';
        }else{
            try {
                $arr['image']=$this->images[0];
            }catch (\Exception $e){
                $arr['image']='';
            }
        }
        $arr['status'] = $this->status;
        $city['id']=$this->city_id;
        $city['name']=$this->city->name;
        $arr['city'] = $city;
        $district['id']=$this->city->district_id;
        $district['name']=$this->city->district->name;
        $arr['district'] = $district;
        $arr['is_favourite']=false;
        $arr['published']=$this->published();
        $arr['mobile_show']=false;
        if($request->header('apiToken')){
            $check_token=$this->check_apiToken($request->header('apiToken'));
            if($check_token && $this->apiToken == true){
                return $check_token;
            }
            $split = explode("sa3d01",$request->header('apiToken'));
            $user=User::where('apiToken',$split['1'])->first();
            if ($user){
                $fav=Favourite::where(['ad_id'=>$this->id,'user_id'=>$user->id])->first();
                $arr['is_favourite']=(bool)$fav;
                $chat=Chat::where(['ad_id'=>$this->id,'sender_id'=>$user->id])->orWhere(['ad_id'=>$this->id,'receiver_id'=>$user->id])->first();
                if($chat){
                    $arr['ad_id']=$chat->room;
                }
                if ($this->mobile===1 || $this->mobile===true){
                    $arr['mobile_show']=true;
                }
            }

        }
        return $arr;
    }
    public function check_apiToken($apiToken)
    {
        if($apiToken){
            try{
                $split = explode("sa3d01",$apiToken);
                $user=User::where('apiToken',$split['1'])->first();
            }catch (\Exception $e){
                return response()->json(['status' => 401 ,'msg' => 'Invalid authentication token in request']);
            }
            if(!$user){
                return response()->json(['status' => 401 ,'msg' => 'Invalid authentication token in request ']);
            }
        }else{
            return response()->json(['status' => 401 ,'msg' => 'Invalid authentication token in request ']);
        }
    }
}
