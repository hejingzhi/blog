<?php

namespace App\Repositories\Backend\V1;

use App\Models\Backend\V1\Conf;
use App\Repositories\BaseRepository;

class ConfRepository extends BaseRepository
{
    public function __construct(Conf $conf)
    {
        $this->model = $conf;
    }
}
