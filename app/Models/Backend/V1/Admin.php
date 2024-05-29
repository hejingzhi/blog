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
    
    protected $fillable = ['admin_name', 'admin_username', 'admin_password', 'admin_phone', 'admin_gender', 'admin_status', 'admin_picture','admin_email'];

    protected $visible = ['admin_id','admin_name', 'admin_username', 'admin_password', 'admin_phone', 'admin_gender', 'admin_status', 'admin_picture','admin_email', 'created_at','updated_at'];

    protected $hidden = ['deleted_at'];

    public function setphoneAttribute($value)
    {
        $this->attributes['phone'] = encryptPhone($value);
    }

    public function setpasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

}
