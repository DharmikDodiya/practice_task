<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailQueueJob;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\ListingApiTrait;

class UserController extends Controller
{
    use ListingApiTrait;
    public function list(Request $request){

        $this->ListingValidation();
        $query = User::query();
        $searchable_fields = ['name','email'];
        $data = $this->filterSearchPagination($query,$searchable_fields);

        return success('User List',[
            'users' =>  $data['query']->get(),
            'count' =>  $data['count'],
        ]);
        
    }

    public function changePassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|same:password_confirmation',
        ]);

        if(!Hash::check($request->old_password, auth()->user()->password)){
            return error("error", "Old Password Doesn't match!",type:'notfound');
        }
        User::whereId(auth()->user()->id)->update([
            'password'  =>Hash::make($request->new_password),
        ]);

        return success('password Change Successfully');
    }

    public function userProfile(){
        $user = Auth::user();

        if(isset($user)){
            return Success('user profile',$user);
        }
        return error('Not User Login',type:'unauthenticated');
    }

    public function logout(){
        $user = Auth::user()->token();
        $user->revoke();
        return success('logged out');
    }


   
}
