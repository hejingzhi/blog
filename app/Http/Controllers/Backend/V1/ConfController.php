<?php

namespace App\Http\Controllers\Backend\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\V1\ConfRequest;
use App\Http\Requests\Backend\V1\ListRequest;
use App\Http\Services\Backend\V1\ConfService;
use Illuminate\Support\Facades\Cache;

class ConfController extends Controller
{
    public function __construct(ConfService $confService)
    {
        $this->service = $confService;
    }

    public function list(ListRequest $request)
    {
        $keyword = $request->input('keyword') ?? '';
        $page = $request->input('page') ?? 1;
        $pageSize = $request->input('pageSize') ?? PAGESIZE;
        $orderType = $request->input('orderType') ?? 'desc';
        $orderName = $request->input('orderName') ?? 'conf_id';
        $list = $this->service->findAll($keyword, [$orderName => $orderType], ['*'], true, $page, $pageSize);
        $total = $this->service->count($keyword);

        //后续 增加这个
        // $table = [
        //     'field' => [
        //         [
        //             'prop' => 'conf_id',
        //             'label' => '编号',
        //             'must' => true,
        //             'sortable' => true,
        //         ], [
        //             'prop' => 'conf_name',
        //             'label' => '配置名称',
        //             'must' => false,
        //             'sortable' => true,
        //         ], [
        //             'prop' => 'conf_key',
        //             'label' => '查询键',
        //             'must' => false,
        //             'sortable' => true,
        //         ], [
        //             'prop' => 'conf_type',
        //             'label' => '配置类型',
        //             'must' => false,
        //             'sortable' => true,
        //         ]
        //     ]
        // ];
        $data = ['data' => $list, 'total' => $total,'table' => 'conf'];
        $data['conf'] = conf('conf_type');

        return apiSuccessData($data);
    }

    public function create(ConfRequest $request)
    {
        $data = $request->validated();
        $confContent = json_decode($data['conf_content'], true);
        $data['conf_content'] = json_encode($this->service->preDeal($confContent));
        $result = $this->service->create($data);
        Cache::forever($data['conf_key'], $confContent);
        return $result ? apiSuccessData($result) : apiFailureData();
    }

    public function update(ConfRequest $request)
    {
        $data = $request->validated();
       
        $confContent = json_decode($data['conf_content'], true);
        $data['conf_content'] = json_encode($this->service->preDeal($confContent));
        $result = $this->service->update($data,$data['conf_id']);
        
        Cache::forever($data['conf_key'], $confContent);
        return $result ? apiSuccessData() : apiFailureData();
    }

    public function delete(ConfRequest $request)
    {
        $detail = $this->service->findOne($request->input('conf_id'), ['conf_key']);
        $result = $this->service->delete($request->input('conf_id'));
        Cache::delete($detail['conf_key']);
        return $result ? apiSuccessData() : apiFailureData();
    }

    public function detail(ConfRequest $request)
    {
        $result = $this->service->findOne($request->input('conf_id'), ['*']);
        return apiSuccessData($result);
    }

    public function getFromOut(ConfRequest $request)
    {
        $keys = explode(',', $request->input('keys'));
        $result = [];
        foreach ($keys as $key) {
            $result += conf($key, $key);
        }

        return apiSuccessData($result);
    }

    public function updateCache()
    {
        Cache::flush();
        $result = $this->service->findAll('', [], ['conf_key', 'conf_content'], false);
        foreach ($result as $val) {
            $confKey = $val['conf_key'];
            $confContent = $val['conf_content'];
            Cache::forever($confKey, $confContent);
        }
        return apiSuccessData();
    }
}
