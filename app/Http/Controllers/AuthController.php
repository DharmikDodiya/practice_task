<?php

namespace App\Http\Controllers;

use App\Jobs\Report;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\WelcomeMessageNotification;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'                  => 'required|string|max:50',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:6|max:12|same:password_confirmation',
            'password_confirmation' => 'required'
        ]); 

        $user = User::create($request->only('name','email')
        +[
            'token'     => Str::random(64),
            'password'  => Hash::make($request->password)
        ]);

        $user->notify(new WelcomeMessageNotification($user));
        //Report::dispatch($user)->delay(now()->addSecond());
        return success('you Are Register Now,send mail please verify your mail',$user);
    }

    public function verifyAccount($token){
        $verifyuser = User::where('token',$token)->first();

        if(!is_null($verifyuser)){
            $user = $verifyuser->user;
            $verifyuser->status = 1;
            $verifyuser->email_verified_at = now();
            $verifyuser->token = '';
            $verifyuser->save();

            return success('your email is verified now you can login');
        }
        else{
            return error('your email is already verified',type:'notfound');
        }
    }

    public function login(Request $request){
        $data = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        if(Auth::attempt(['email' => $request->email , 'password' => $request->password , 'status' => 1])){
            $user = User::where('email',$request->email)->first();

            $token = $user->createToken("API TOKEN")->accessToken;
            return success('you are Login Now',$token);
        }
        else{
            return error('email and password are not match',type:'notfound');
        }   

    }

    public function forgetPassword(Request $request){
        $request->validate([
            'email'     => 'email|exists:users,email'
        ]);

        $user = User::where('email',$request->email)->first();

        if(isset($user)){
            $token = Str::random(64);
            $domain = URL::to('/');
            $url = $domain.'/api/resetPassword?token='.$token."&email=".$request->email;

            $data['url']    = $url;
            $data['email']  = $request->email;
            $data['title']  = 'Password Reset';
            $data['body']   = 'please click below link to Reset your Password';
            
            Mail::send('forgetPasswordMail',['data' => $data],function($message) use ($data){
                $message->to($data['email'])->subject($data['title']);
            });

            $datetime = Carbon::now()->format('Y-m-d H:i:s');
            PasswordReset::updateOrCreate(
                ['email' => $request->email],
                [
                    'email'         =>$request->email,
                    'token'         => $token,
                    'created_at'    => $datetime,
                ]
            );

            return success('send mail please check your mail',$token);
        }
        return error('Email Is Not Exists',type:'notfound');
    }

    public function forgetPasswordView(Request $request){
        $resetdata = PasswordReset::where('token',$request->token)->first();

        if(isset($resetdata)){
            return success('now you can chenge the password use this token',$request->token);
        }
        return error('you can Not Change The Password',type:'notfound');
    }

    public function resetPassword(Request $request){
        $request->validate([
            'password'      => 'required|same:password_confirmation',
            'token'         => 'required',
        ]);

        $data = PasswordReset::where('token',$request->token)->first();

        if(isset($data)){
            $user = User::where('email',$data->email)->first();
            $user->update(['password' => Hash::make($request->password)]);
            $data->update(['token' => '']);
            return success('your password change successfully');
        }
        return error('your Token Is Expired',type:'notfound');
    }
}
