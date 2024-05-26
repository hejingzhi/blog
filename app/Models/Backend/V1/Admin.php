<?php

namespace App\Models\Backend\V1;

use App\Models\BaseModel;


class Admin extends BaseModel
{
    public $timestamps = true;

    protected $table = 'admin';

    protected $primaryKey = 'admin_id';

    protected $keyType = 'int';

    public $incrementing = true;

    protected $perPage = 15;

    protected $fillable = ['name', 'username', 'password', 'phone', 'gender', 'status', 'picture','email'];

    protected $hidden = ['updated_at','deleted_at'];

    protected $dates = ['delete_at'];
    public function setphoneAttribute($value)
    {
        $this->attributes['phone'] = encryptPhone($value);
    }

    public function setpasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

}
