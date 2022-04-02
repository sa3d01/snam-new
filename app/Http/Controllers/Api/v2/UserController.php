<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Api\MasterController;
use App\Models\Ad;
use App\User;
use Edujugon\PushNotification\PushNotification;
use Illuminate\Http\Request;

class UserController extends MasterController
{
    public function __construct(User $model)
    {
        $this->model = $model;
        $this->route = 'users';
        $this->apiToken = true;
        parent::__construct();
    }

    public function user_ads($id, Request $request)
    {
        $offset = $request->header('skip', 0);
        $rows = Ad::where('user_id', $id)->latest()->offset($offset)->limit(10)->get();
        $count = Ad::where('user_id', $id)->latest()->count();
        $data = [];
        foreach ($rows as $row) {
            $arr = $row->static_model();
            $arr['is_favourite'] = false;
            unset($arr['user']);
            if ($request->header('apiToken')) {
                $check_token = $this->check_apiToken($request->header('apiToken'));
                if ($check_token && $this->apiToken == true) {
                    return $check_token;
                }
                $split = explode("sa3d01", $request->header('apiToken'));
                $user = User::where('apiToken', $split['1'])->first();
                $fav = Favourite::where(['ad_id' => $row->id, 'user_id' => $user->id])->first();
                $arr['is_favourite'] = $fav ? true : false;
            }
            $data[] = $arr;
        }
        return response()->json(['status' => 200, 'data_count' => $count, 'data' => $data]);
    }

    public function testFcm()
    {
        $users=User::whereIn('id',[2840,19])->get();

        $usersTokens=[];
        $usersIds=[];
        foreach ($users as $user){
            if ($user->device_token !=null){
                if(gettype($user->device_token)=='string'){
                    $usersTokens[]=$user->device_token;
                }else{
                    foreach ($user->device_token as $token){
                        $usersTokens[]=$token;
                    }
                }
                $usersIds[]=$user->id;
            }
        }

        $push = new PushNotification('fcm');
        $msg = [
            'notification' => [
                'title'=>'test',
                'sound' => 'default',
                'click_action' => 'FCM_PLUGIN_ACTIVITY',
            ],
            'data' => [
                'title'=>'الإدارة',
                'body' => 'test',
                'status' => 'admin',
                'type'=>'admin'
            ],
            'priority' => 'high',
        ];
        $feed_backs=$push->setMessage($msg)
            ->setDevicesToken($usersTokens)
            ->send()
            ->getFeedback();
        dd($feed_backs);


    }
}
