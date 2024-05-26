<?php

namespace App\Http\Services;

use App\Repositories\BaseRepository;
use \Closure;

class BaseService
{

    /**
     * @var BaseRepository $repository
     */
    protected $repository;
}
