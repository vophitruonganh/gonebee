<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Entities\User as User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Mockery\Exception;

class FacebookController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */

    public function redirectToProvider()
    {
        return Socialite::driver('facebook')
            ->scopes(['email', 'public_profile','user_friends'])
            ->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try{
            $userSocial = Socialite::driver('facebook')->user();

            $user = User::where('fb_user_id' ,'=', $userSocial->id)->first();
            if ($user){
                if(Auth::check()){
                    return redirect()->back();
                }else{
                    Auth::login($user);
                    return redirect()->back();
                }

            }else{
                $this->loginOrRegister($userSocial);
            }
            return redirect('/');

        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
        // $user->token;
    }

    /**
     * @param array $user
     * @return array|string
     */
    private function loginOrRegister($user = array()){
        try{
            if ($user){
                $checkUser = User::where('fb_user_id','=',$user->id)->first();
                if($checkUser){
                    Auth::login($checkUser);
                }else{
                    User::createOrUpdate($user);
                    return redirect()->back();
                }
            }else{
                return 'Invalid user information, user info not empty';
            }
        }catch (Exception $e){
            if($request->ajax()){
                return response()->json($e->getMessage());
            }else{
                return $e->getMessage();
            }
            
        }
    }
}
