<?php

namespace App\Http\Services\Backend\V1;

use App\Http\Services\BaseService;
use App\Repositories\Backend\V1\AdminRepository;

class AdminService extends BaseService
{
    protected $repository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->repository = $adminRepository;
    
    }

    public function add(array $record)
    {
        return $this->repository->add($record);
    }

}
