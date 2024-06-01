<?php

namespace App\Http\Controllers\Frontend\v1;
use Illuminate\Http\Request;  
use Tymon\JWTAuth\Facades\JWTAuth;  
use Tymon\JWTAuth\Exceptions\JWTException;  
use Illuminate\Support\Facades\Hash;
use App\Models\Frontend\V1\User;

 class TestController
{
    public function create(Request $request){
        $credentials = $request->only('name', 'password');  
        $credentials ['password'] = Hash::make($credentials['password']);
        $info= User::create($credentials);
        var_dump($info);
        exit;
      }
  
    public function me(){
        $user_info = auth()->guard('frontend')->user()->toArray();
        var_dump($user_info);
    }
    public function login(Request $request){
        $credentials = $request->only('name', 'password');  
        try {  
            // 尝试使用凭据登录  
            if (!$token = auth()->guard('frontend')->attempt($credentials)) {  
                return response()->json(['error' => 'invalid_credentials'], 401);  
            }  
        } catch (JWTException $e) {  
            // 捕获 JWT 生成异常  
            return response()->json(['error' => 'could_not_create_token'], 500);  
        }  
        // 如果登录成功，返回 token  
        return response()->json(compact('token'));  
    }
   
}
