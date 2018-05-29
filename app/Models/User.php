<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','confirmation_token','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function owns($model)
    {
        return $this->id == $model->user_id;
    }


    /**
     * 重写找回密码
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $view = 'email.restpassword';
        //$this->token = $token;
        $data = compact('user','token');
        $from = '906314530@qq.com';
        $name = 'BlindLq';
        $to = $this->email;
        $subject = " zhihu-app 应用找回密码邮件。";

        //调用mail接口
        Mail::send($view,$data,function ($message) use ($from,$name,$to,$subject){
            $message->from($from,$name)->to($to)->subject($subject);
        });

//        return (new MailMessage)
//            ->line('You are receiving this email because we received a password reset request for your account.')
//            ->action('Reset Password', url(config('app.url').route('password.reset', $this->token, false)))
//            ->line('If you did not request a password reset, no further action is required.');

    }
}
