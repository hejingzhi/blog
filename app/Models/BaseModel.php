<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class BaseModel extends Model
{
    use LogsActivity;
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
