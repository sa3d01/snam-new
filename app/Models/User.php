<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function scopeActive($query)
    {
        $query->where('status','active');
    }
    protected $casts = [
        'device_token' => 'json',
    ];
    protected $fillable = [
        'username','device_token','apiToken', 'mobile', 'password', 'status', 'approved', 'online','city_id','image','activation_code'
    ];
    protected $index_fields  =  ['id','username','apiToken', 'mobile', 'status', 'approved', 'online','city_id','image'];

    public function static_model()
    {
        $arr=[];
        foreach ($this->index_fields as $index_field){
            if(substr($index_field, "-3")=='_id'){
                $related_model=substr_replace($index_field, "", -3);
                if($this->$related_model !=null){
                    $model=$this->$related_model->static_model();
                }else{
                    $model='';
                }
                $this->$index_field ? $arr[$related_model] = $model : $arr[$related_model] ='';
            }elseif (substr($index_field, "-3")!='_id'){
                $this->$index_field ? $arr[$index_field] = $this->$index_field : $arr[$index_field] ='';
            }
        }
        $count_rating=Rating::where('rated_id',$this->id)->count();
        $sum_rating=Rating::where('rated_id',$this->id)->sum('rate');
        $arr['total_rating'] = $count_rating==0 ? 0 : round($sum_rating/$count_rating);
        $default_city=City::first();
        $arr['city']=$this->city? $this->city->static_model() : $default_city->static_model();
        $arr['district']=$this->city? $this->city->district->static_model() : null;
        $arr['from']=$this->published();
        return $arr;
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class,'rated_id','id');
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class,'receiver_id','id');
    }
    public function ads()
    {
        return $this->hasMany(Ad::class,'user_id','id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
    public function getDistanceBetweenPoints($shop_lat, $shop_long, $unit = 'Km')
    {
        $user_lat=$this->attributes['lat'];
        $user_long=$this->attributes['long'];
        $theta = $user_long - $shop_long;
        $distance = (sin(deg2rad($user_lat)) * sin(deg2rad($shop_lat))) + (cos(deg2rad($user_lat)) * cos(deg2rad($shop_lat)) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        switch($unit) {
            case 'Mi': break; case 'Km' : $distance = $distance * 1.609344;
        }
        return (round($distance));
    }
    public function setImageAttribute()
    {
        if (is_file(request()->image)){
            $file = request()->file('image');
            $destinationPath = 'images/user/';
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $this->attributes['image'] = $filename;
        }else{
            $this->attributes['image'] = request()->image;
        }

    }
    public function getImageAttribute()
    {
        try {
            if($this->attributes['image'] != null)
                return asset('images/user/').'/'.$this->attributes['image'];
            return asset('images/user/default.jpeg');
        } catch (\Exception $e) {
            return asset('images/user/default.jpeg');
        }
    }
    public function setPasswordAttribute($password)
    {
        if (isset($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }
    public function activate()
    {
        $var = route('active_user',['id'=>$this->id]);
        $token = csrf_token();
        if($this->approved=='true') {
            return "<form style='margin-top: 20px' method='POST' action='$var' class='form-horizontal'>
                <input type='hidden' name='_token' value='$token'>
                <button type='submit' class='btn btn-danger btn-rounded waves-effect waves-light'>
                <span class='btn-label'><i class='fa fa-times'></i></span>
                الغاء التفعيل</button>

            </form>";
        }
        return "<form style='margin-top: 20px' method='POST' action='$var' class='form'>
                <input type='hidden' name='_token' value='$token'>
                <button type='submit' class='btn btn-success btn-rounded waves-effect waves-light'>
                <span class='btn-label'><i class='fa fa-check'></i></span>
                تفعيل</button>

            </form>";
    }

    public function setMobileAttribute($mobile){
        $first_val = substr($mobile, 0, 1 );
        if ($first_val=="0") {
            $this->attributes['mobile'] = '+966'.substr($mobile, 1);
        }elseif($first_val == "5"){
            $this->attributes['mobile'] = '+966'.$mobile;
        }else{
            $this->attributes['mobile']=$mobile;
        }
    }
    public static function sendMessage($message, $phoneNumber)
    {
        //966555001022
        //Sn@m@2o22

        $getdata = http_build_query(
            $fields = array(
                "username" => "966555001022",
                "password" => "Sn@m@2o22",
                "message" => $message,
                "numbers" => $phoneNumber,
                "sender" => "snam",
            ));
        $opts = array('http' =>
            array(
                'method' => 'GET',
                'header' => 'Content-type: application/x-www-form-urlencoded',
            )
        );
        $context = stream_context_create($opts);
        $results = file_get_contents('https://www.hisms.ws/api.php?send_sms&' . $getdata, false, $context);
        return $results;
    }
    public static function oldSendMessage($message, $phoneNumber)
    {
        //966555001022
        //Sn@m@2o22

        $getdata = http_build_query(
            $fields = array(
                "Username" => "0555001022",
                "Password" => "123456",
                "Message" => $message,
                "RecepientNumber" => $phoneNumber,
                "ReplacementList" => "",
                "SendDateTime" => "0",
                "EnableDR" => False,
                "Tagname" => "snam",
                "VariableList" => "0"
            ));
        $opts = array('http' =>
            array(
                'method' => 'GET',
                'header' => 'Content-type: application/x-www-form-urlencoded',

            )
        );
        $context = stream_context_create($opts);
        $results = file_get_contents('http://api.yamamah.com/SendSMSV2?' . $getdata, false, $context);
        return $results;
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function published()
    {
        $created_at=Carbon::parse($this->attributes['created_at']);
        $date=explode(',',$this->time($created_at->timestamp));
        return $date[0];
    }
    public static function time($timestamp, $num_times = 3)
    {

        $times = array(31536000 => 'سنة', 2592000 => 'شهر', 604800 => 'اسبوع', 86400 => 'يوم', 3600 => 'ساعة', 60 => 'دقيقة', 1 => 'ثانية');

        $now = time() - 3600;
        $timestamp -= 3600;
        $secs = $now - $timestamp;
        if ($secs == 0) {
            $secs = 1;
        }

        $count = 0;
        $time = '';

        foreach ($times as $key => $value) {
            if ($secs >= $key) {
                $s = '';
                $time .= floor($secs / $key);

                if ((floor($secs / $key) != 1)) $s = ' ';

                $time .= ' ' . $value . $s;
                $count++;
                $secs = $secs % $key;

                if ($count > $num_times - 1 || $secs == 0) break; else
                    $time .= ' , ';
            }
        }
        $st = 'انضمّ قبل ' . $time;
        return $st;
    }
}
