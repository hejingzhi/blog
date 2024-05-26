<?php

namespace App\Repositories\Backend\V1;

use App\Models\Backend\V1\Admin;
use App\Repositories\BaseRepository;

class AdminRepository extends BaseRepository
{


    public function __construct(Admin $admin)
    {
        $this->model = $admin;
    }

}
