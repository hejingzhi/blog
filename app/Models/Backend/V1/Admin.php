<?php

namespace App\Models\Backend\V1;

use App\Models\BaseModel;

use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable; // 引入Authenticatable
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;//软删除  有bug的和验证唯一 id取值有BUG
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
class Admin extends Authenticatable  implements JWTSubject
{
    use Notifiable,LogsActivity,SoftDeletes;
    
    public $timestamps = true;

    protected $table = 'admin';

    protected $primaryKey = 'admin_id';

    protected $keyType = 'int';

    public $incrementing = true;

    protected $perPage = 15;
    
    protected $fillable = ['admin_name', 'admin_username', 'admin_password', 'admin_phone', 'admin_gender', 'admin_status', 'admin_picture','admin_email'];

    protected $visible = ['admin_id','admin_name', 'admin_username', 'admin_password', 'admin_phone', 'admin_gender', 'admin_status', 'admin_picture','admin_email', 'created_at','updated_at'];

    protected $hidden = ['deleted_at'];

    public function setAdminPhoneAttribute($value)
    {
        $this->attributes['admin_phone'] = encryptPhone($value);
    }

    public function setAdminPasswordAttribute($value)
    {
        $this->attributes['admin_password'] = Hash::make($value);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey(); // 返回主键ID，通常是id字段
    }
    public function getJWTCustomClaims()
    {
       // 后端认证
        return ['role' => 'admin'];
    }
    public function getAuthPassword()
    {
        return $this->admin_password; // 使用admin_password字段
    }
    protected $dateFormat = 'Y-m-d H:i:s.u';

    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->tz(config('app.timezone'))->format('Y-m-d H:i:s') : null;
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->tz(config('app.timezone'))->format('Y-m-d H:i:s') : null;
    }

    public function scopeBetweenCustomTime($query, $timeField = 'created_at')
    {
        $timeField = Str::of($timeField)->contains('.') ? $timeField : $this->table . '.' . $timeField;
        $request = request();
        if ($request->filled('startTime')) {
            $query->where($timeField, '>=', $request->input('startTime'));
        }

        if ($request->filled('endTime')) {
            $query->where($timeField, '<=', $request->input('endTime'));
        }

        return $query;
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName($this->table)
            ->logFillable()
            ->logUnguarded();
    }
}
