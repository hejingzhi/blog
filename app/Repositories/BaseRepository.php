<?php

namespace App\Repositories;

use App\Models\BaseModel;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    /**
     * @var BaseModel $model
     */
    protected $model;

    /**
     * @param array $record
     * @return Builder|Model
     *
     *  ┏┓　　　┏┓
     *┏┛┻━━━┛┻┓
     *┃　　　　　　　┃ 　
     *┃　　　━　　　┃
     *┃　┳┛　┗┳　┃
     *┃　　　　　　　┃
     *┃　　　┻　　　┃
     *┃　　　　　　　┃
     *┗━┓　　　┏━┛
     *　　┃　　　┃神兽护体
     *　　┃　　　┃请在子类中复写，不要直接修改哦
     *　　┃　　　┗━━━┓
     *　　┃　　　　　　　┣┓
     *　　┃　　　　　　　┏┛
     *　　┗┓┓┏━┳┓┏┛
     *　　　┃┫┫　┃┫┫
     *　　　┗┻┛　┗┻┛
     *
     */
    public function create(array $record)
    {
        return $this->model->newQuery()->create($record);
    }

    /**
     * @param array $record
     * @param $idOrCondition
     * @return bool|int
     *
     *  ┏┓　　　┏┓
     *┏┛┻━━━┛┻┓
     *┃　　　　　　　┃ 　
     *┃　　　━　　　┃
     *┃　┳┛　┗┳　┃
     *┃　　　　　　　┃
     *┃　　　┻　　　┃
     *┃　　　　　　　┃
     *┗━┓　　　┏━┛
     *　　┃　　　┃神兽护体
     *　　┃　　　┃请在子类中复写，不要直接修改哦
     *　　┃　　　┗━━━┓
     *　　┃　　　　　　　┣┓
     *　　┃　　　　　　　┏┛
     *　　┗┓┓┏━┳┓┏┛
     *　　　┃┫┫　┃┫┫
     *　　　┗┻┛　┗┻┛
     *
     */
    public function update(array $record, $idOrCondition)
    {
        if (!checkIdOrCondition($idOrCondition)) {
            return false;
        }

        $model = $this->model->newQuery();
        if ($idOrCondition instanceof Closure) {
            return $model->where($idOrCondition)->update($record);
        } else {
            return $model->find($idOrCondition)->update($record);
        }
    }

    /**
     * @param $idOrCondition
     * @return bool|mixed|null
     *
     *  ┏┓　　　┏┓
     *┏┛┻━━━┛┻┓
     *┃　　　　　　　┃ 　
     *┃　　　━　　　┃
     *┃　┳┛　┗┳　┃
     *┃　　　　　　　┃
     *┃　　　┻　　　┃
     *┃　　　　　　　┃
     *┗━┓　　　┏━┛
     *　　┃　　　┃神兽护体
     *　　┃　　　┃请在子类中复写，不要直接修改哦
     *　　┃　　　┗━━━┓
     *　　┃　　　　　　　┣┓
     *　　┃　　　　　　　┏┛
     *　　┗┓┓┏━┳┓┏┛
     *　　　┃┫┫　┃┫┫
     *　　　┗┻┛　┗┻┛
     *
     */
    public function delete($idOrCondition)
    {
        if (!checkIdOrCondition($idOrCondition)) {
            return false;
        }
        $model = $this->model->newQuery();
   
        if ($idOrCondition instanceof Closure) {
            return $model->where($idOrCondition)->delete();
        } else {
        
            return $model->find($idOrCondition)->delete();
        }
    }

    /**
     * @param Closure|null $condition
     * @param string $column
     * @return int
     *
     *  ┏┓　　　┏┓
     *┏┛┻━━━┛┻┓
     *┃　　　　　　　┃ 　
     *┃　　　━　　　┃
     *┃　┳┛　┗┳　┃
     *┃　　　　　　　┃
     *┃　　　┻　　　┃
     *┃　　　　　　　┃
     *┗━┓　　　┏━┛
     *　　┃　　　┃神兽护体
     *　　┃　　　┃请在子类中复写，不要直接修改哦
     *　　┃　　　┗━━━┓
     *　　┃　　　　　　　┣┓
     *　　┃　　　　　　　┏┛
     *　　┗┓┓┏━┳┓┏┛
     *　　　┃┫┫　┃┫┫
     *　　　┗┻┛　┗┻┛
     *
     */
    public function count(Closure $condition = null, string $column = '*')
    {
        return $this->model->newQuery()->where($condition)->count($column);
    }

    /**
     * @param Closure|null $condition
     * @param string $column
     * @param string $timeField
     * @return int
     *
     *  ┏┓　　　┏┓
     *┏┛┻━━━┛┻┓
     *┃　　　　　　　┃ 　
     *┃　　　━　　　┃
     *┃　┳┛　┗┳　┃
     *┃　　　　　　　┃
     *┃　　　┻　　　┃
     *┃　　　　　　　┃
     *┗━┓　　　┏━┛
     *　　┃　　　┃神兽护体
     *　　┃　　　┃请在子类中复写，不要直接修改哦
     *　　┃　　　┗━━━┓
     *　　┃　　　　　　　┣┓
     *　　┃　　　　　　　┏┛
     *　　┗┓┓┏━┳┓┏┛
     *　　　┃┫┫　┃┫┫
     *　　　┗┻┛　┗┻┛
     *
     */
    public function countBetweenCustomTime(Closure $condition = null, string $column = '*', string $timeField = 'created_at')
    {
        return $this->model->newQuery()->where($condition)->betweenCustomTime($timeField)->count($column);
    }

    /**
     * @param null $idOrCondition
     * @param array $columns
     * @return bool|Builder|Model|object|null
     *
     *  ┏┓　　　┏┓
     *┏┛┻━━━┛┻┓
     *┃　　　　　　　┃ 　
     *┃　　　━　　　┃
     *┃　┳┛　┗┳　┃
     *┃　　　　　　　┃
     *┃　　　┻　　　┃
     *┃　　　　　　　┃
     *┗━┓　　　┏━┛
     *　　┃　　　┃神兽护体
     *　　┃　　　┃请在子类中复写，不要直接修改哦
     *　　┃　　　┗━━━┓
     *　　┃　　　　　　　┣┓
     *　　┃　　　　　　　┏┛
     *　　┗┓┓┏━┳┓┏┛
     *　　　┃┫┫　┃┫┫
     *　　　┗┻┛　┗┻┛
     *
     */
    public function findOne($idOrCondition = null, array $columns = ['*'])
    {
        if (!checkIdOrCondition($idOrCondition)) {
            return false;
        }

        $model = $this->model->newQuery();

        if ($idOrCondition instanceof Closure) {
            $model->where($idOrCondition);
        } else {
            $model->find($idOrCondition);
        }

        return $model->select($columns)->first();
    }

    /**
     * @param Closure|null $condition
     * @param array $orderBys
     * @param array $columns
     * @param bool $needPaginate
     * @param int $page
     * @param int $pageSize
     * @return Builder[]|Collection
     *
     *  ┏┓　　　┏┓
     *┏┛┻━━━┛┻┓
     *┃　　　　　　　┃ 　
     *┃　　　━　　　┃
     *┃　┳┛　┗┳　┃
     *┃　　　　　　　┃
     *┃　　　┻　　　┃
     *┃　　　　　　　┃
     *┗━┓　　　┏━┛
     *　　┃　　　┃神兽护体
     *　　┃　　　┃请在子类中复写，不要直接修改哦
     *　　┃　　　┗━━━┓
     *　　┃　　　　　　　┣┓
     *　　┃　　　　　　　┏┛
     *　　┗┓┓┏━┳┓┏┛
     *　　　┃┫┫　┃┫┫
     *　　　┗┻┛　┗┻┛
     *
     */
    public function findAll(Closure $condition = null, array $orderBys = [], array $columns = ['*'], bool $needPaginate = true, int $page = 1, int $pageSize = 0)
    {
        $pageSize = $pageSize <= 0 ? config('page.pageSize') : $pageSize;

        $model = $this->model->newQuery()->where($condition);

        foreach ($orderBys as $column => $direction) {
            $model->orderBy($column, $direction);
        }

        if ($needPaginate) {
            $model->forPage($page, $pageSize);
        }

        return $model->select($columns)->get();
    }


    /**
     * @param Closure|null $condition
     * @param array $orderBys
     * @param array $columns
     * @param bool $needPaginate
     * @param int $page
     * @param int $pageSize
     * @param string $timeField
     * @return Builder[]|Collection
     *
     *  ┏┓　　　┏┓
     *┏┛┻━━━┛┻┓
     *┃　　　　　　　┃ 　
     *┃　　　━　　　┃
     *┃　┳┛　┗┳　┃
     *┃　　　　　　　┃
     *┃　　　┻　　　┃
     *┃　　　　　　　┃
     *┗━┓　　　┏━┛
     *　　┃　　　┃神兽护体
     *　　┃　　　┃请在子类中复写，不要直接修改哦
     *　　┃　　　┗━━━┓
     *　　┃　　　　　　　┣┓
     *　　┃　　　　　　　┏┛
     *　　┗┓┓┏━┳┓┏┛
     *　　　┃┫┫　┃┫┫
     *　　　┗┻┛　┗┻┛
     *
     */
    public function findAllBetweenCustomTime(Closure $condition = null, array $orderBys = [], array $columns = ['*'], bool $needPaginate = true, int $page = 1, int $pageSize = 0, string $timeField = 'created_at')
    {
        $pageSize = $pageSize <= 0 ? config('page.pageSize') : $pageSize;

        $model = $this->model->newQuery()->where($condition);

        foreach ($orderBys as $column => $direction) {
            $model->orderBy($column, $direction);
        }

        if ($needPaginate) {
            $model->forPage($page, $pageSize);
        }

        return $model->select($columns)->betweenCustomTime($timeField)->get();
    }
}
