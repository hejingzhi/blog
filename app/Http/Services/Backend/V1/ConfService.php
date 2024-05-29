<?php

namespace App\Http\Services\Backend\V1;

use App\Http\Services\BaseService;

use  App\Repositories\Backend\V1\ConfRepository;
use Illuminate\Support\Str;

class ConfService extends BaseService
{
    public function __construct(ConfRepository $ConfRepository)
    {
        $this->repository = $ConfRepository;
    }

    public function create(array $record)
    {
        return $this->repository->create($record);
    }

    public function update(array $record, int $id)
    {
        return $this->repository->update($record, $id);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }

    public function count(string $keyword, string $column = '*', bool $needTimeScopeSelect = true, string $timeField = 'created_at')
    {
        $condition = null;
        if ($keyword != '') {
            $condition = function ($query) use ($keyword) {
                $query->where('conf_key', 'like', '%' . $keyword . '%')->orWhere('conf_name', 'like', '%' . $keyword . '%');
            };
        }

        return $needTimeScopeSelect ? $this->repository->countBetweenCustomTime($condition, $column, $timeField) : $this->repository->count($condition, $column);
    }

    public function findOne(int $id, array $columns = ['*'])
    {
        return $this->repository->findOne($id, $columns);
    }

    public function findByConfKey(string $confKey)
    {
        $condition = function ($query) use ($confKey) {
            $query->where('conf_key', $confKey);
        };

        return $this->repository->findOne($condition, ['conf_content']);
    }

    public function findAll(string $keyword, array $orderBys = [], array $columns = ['*'], bool $needPaginate = true, int $page = 1, int $pageSize = 0, bool $needTimeScopeSelect = true, string $timeField = 'created_at')
    {

        $condition = null;
        if ($keyword != '') {
            $condition = function ($query) use ($keyword) {
                $query->where('conf_key', 'like', '%' . $keyword . '%')->orWhere('conf_name', 'like', '%' . $keyword . '%');
            };
        }

        return $needTimeScopeSelect ? $this->repository->findAllBetweenCustomTime($condition, $orderBys, $columns, $needPaginate, $page, $pageSize, $timeField) : $this->repository->findAll($condition, $orderBys, $columns, $needPaginate, $page, $pageSize);
    }

    public function preDeal(&$confContent)
    {
        if (is_array($confContent)) {
            foreach ($confContent as $key => &$val) {
               
                if (is_numeric($val)) {
                    if (Str::of($val)->contains('.')) {
                        $val = doubleval($val);
                    } else {
                        $val = intval($val);
                    }
                } else if (is_array($val)) {
                    $val = $this->preDeal($val);
                }
            }
        } else if (is_numeric($confContent)) {
            $confContent = doubleval($confContent);
        }

        return $confContent;
    }
}
