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

    public function create(array $record)
    {
        return $this->repository->create($record);
    }
    public function update(array $record,int $id)
    {
        return $this->repository->update($record,$id);
    }
    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
    public function detail(int $id)
    {
        return $this->repository->findOne($id);
    }
}
