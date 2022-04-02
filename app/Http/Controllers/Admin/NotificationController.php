<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Edujugon\PushNotification\PushNotification;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class NotificationController extends MasterController
{
    public function __construct(Notification $model)
    {
        $this->model = $model;
        $this->route = 'notification';
        $this->module_name         = 'قائمة الاشعارات ';
        $this->single_module_name  = 'اشعار';
        parent::__construct();
    }

    public function validation_func($method,$id=null)
    {
        $therulesarray = [];
        $therulesarray['note'] ='required';
        return $therulesarray;
    }
    public function create()
    {
        return view('admin.' . $this->route . '.create');
    }
    public function index()
    {
        $rows = $this->model->where(['type'=>'admin','collective_notice'=>'true'])->latest()->get();
        return view('admin.' . $this->route . '.index', compact('rows'));
    }
    public function collective_notice()
    {
        $rows = $this->model->where(['type'=>'admin','collective_notice'=>'true'])->latest()->get();
        $collection = collect($rows);
        $rows = $collection->unique('note');
        $rows->values()->all();
        // return $rows;
        return view('admin.' . $this->route . '.index', compact('rows'));
    }
    public function store(Request $request)
    {
        $this->validate($request, $this->validation_func(1));
        $users=User::all();

        $usersTokens=[];
        $usersIds=[];
        foreach ($users as $user){
            $userTokens=[];
            if ($user->device_token !=null){
                foreach ((array)$user->device_token as $token){
                    $userTokens[]=$token;
                }
                $usersIds[]=$user->id;
            }
            $usersTokens[] = Arr::flatten($userTokens);

        }
        $usersTokens = Arr::flatten($usersTokens);

        $token_arrays=array_chunk($usersTokens, 900);
        foreach ($token_arrays as $token_array){
            $push = new PushNotification('fcm');
            $msg = [
                'notification' => [
                    'title'=>'رسالة إدارية',
                    'body'=>$request['note'],
                    'sound' => 'default',
                    'click_action' => 'FCM_PLUGIN_ACTIVITY',
                ],
                'data' => [
                    'title'=>'رسالة إدارية',
                    'body' => $request['note'],
                    'status' => 'admin',
                    'type'=>'admin'
                ],
                'priority' => 'high',
            ];
            $feed_backs=$push->setMessage($msg)
                ->setDevicesToken($token_array)
                ->send()
                ->getFeedback();
        }
        $note=new Notification();
        $note->type='admin';
        $note->collective_notice='true';
        $note->receivers=$usersIds;
        $note->title='الإدارة';
        $note->note=$request['note'];
        $note->save();
        return redirect()->route('notification.collective_notice')->with('notify', 'تم الارسال بنجاح');
    }
}
