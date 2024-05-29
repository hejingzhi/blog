<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;//软删除  有bug的和验证唯一 id取值有BUG
class BaseModel extends Model
{
    use LogsActivity,SoftDeletes;
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
