<?php

namespace App\Services;

use App\User;
use Jwt;

class UserService {

    private $jwt;

    public function __construct(Jwt $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * Create jwt for user
     *
     * @param  $request
     * @return string
     */
    public function generateUserToken($request){

        $response = [];
        $user = User::where('email', $request['email'] )->where('password', md5($request['password']))->first();
        if($user){
            if(!$user->remember_token) {
                $token = $this->jwt->generate($user->name);
                $user->update(['remember_token' => $token]);
                $response['token'] = $token;
            }
            else{
                if($this->jwt->validate($user->remember_token)){
                    $response['token_valid'] = true;
                    $response['token'] = $user->remember_token;
                }
                else{
                    $response['token_old'] = $user->remember_token;
                    $token = $this->jwt->generate($user->name);
                    $user->update(['remember_token' => $token]);
                    $response['token_new'] =  $token;
                }
            }
        }

        return $response;
    }

}
