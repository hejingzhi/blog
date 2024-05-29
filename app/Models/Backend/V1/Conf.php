<?php

namespace App\Models\Backend\V1;

use App\Models\BaseModel;
use App\Casts\Json;
class Conf extends BaseModel
{
    protected $casts = ['conf_content' => Json::class];

    public $timestamps = true;

    protected $table = 'conf';

    protected $primaryKey = 'conf_id';

    protected $keyType = 'int';

    public $incrementing = true;

    protected $perPage = 15;

    protected $fillable = ['conf_name', 'conf_key', 'conf_type', 'conf_content'];

    protected $visible = ['conf_id', 'conf_name', 'conf_key', 'conf_type', 'conf_content', 'created_at','updated_at'];

    protected $hidden = ['deleted_at'];

}
