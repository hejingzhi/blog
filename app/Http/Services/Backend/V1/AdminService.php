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
    public function findAll(string $keyword, array $orderBys = [], array $columns = ['*'], bool $needPaginate = true, int $page = 1, int $pageSize = 0, bool $needTimeScopeSelect = true, string $timeField = 'created_at')
    {

        $condition = null;
        if ($keyword != '') {
            $condition = function ($query) use ($keyword) {
                $query->where('admin_username', 'like', '%' . $keyword . '%')->orWhere('admin_name', 'like', '%' . $keyword . '%');
            };
        }

        return $needTimeScopeSelect ? $this->repository->findAllBetweenCustomTime($condition, $orderBys, $columns, $needPaginate, $page, $pageSize, $timeField) : $this->repository->findAll($condition, $orderBys, $columns, $needPaginate, $page, $pageSize);
    }
    public function count(string $keyword, string $column = '*', bool $needTimeScopeSelect = true, string $timeField = 'created_at')
    {
        $condition = null;
        if ($keyword != '') {
            $condition = function ($query) use ($keyword) {
                $query->where('admin_username', 'like', '%' . $keyword . '%')->orWhere('admin_name', 'like', '%' . $keyword . '%');
            };
        }

        return $needTimeScopeSelect ? $this->repository->countBetweenCustomTime($condition, $column, $timeField) : $this->repository->count($condition, $column);
    }
}
