<?php

namespace App\Http\Controllers\Backend\v1;
use Illuminate\Http\Request;  
use Tymon\JWTAuth\Exceptions\JWTException;  

 class TestController
{
    //
    public function me(){
      //  echo '我是Backend的V1的index方法';
        $user_info = Auth()->guard('backend')->user()->toArray();
        var_dump($user_info);
    }
    public function login(Request $request){



        $credentials = $request->only('admin_name', 'admin_password','admin_username');  
        $credentials['password']  = $credentials['admin_password'];
       
        try {  
            // 尝试使用凭据登录  
            if (!$token =Auth()->guard('backend')->attempt($credentials)) {  
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
