<?php

namespace App\Models\Frontend\V1;

use App\Models\BaseModel;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable; // 引入Authenticatable

class User extends Authenticatable  implements JWTSubject
{
    use Notifiable;
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $fillable = ['name', 'password'];
    public function getJWTIdentifier()
    {
        return $this->getKey(); // 返回主键ID，通常是id字段
    }
    public function getJWTCustomClaims()
    {
         //使用前端认证
        return ['role' => 'user'];
    }
}
