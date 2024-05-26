<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseModel extends Model
{
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
}