<?php

namespace App\Http\Controllers\Backend\v1;
use App\Http\Requests\Backend\V1\AdminRequest;
use App\Http\Services\Backend\V1\AdminService;
use App\Http\Controllers\Controller;

 class AdminConreoller extends Controller
{
    public function __construct(AdminService $aminService)
    {
        $this->service = $aminService;
    }
    public function create(AdminRequest $request)
    {
        $result = $this->service->create($request->validated());
        return $result ? apiSuccessData($result) : apiFailureData();    
    }

    public function update(AdminRequest $request)
    {
        $data = $request->validated();
        $result = $this->service->update($data,$data['admin_id']);
        return $result ? apiSuccessData() : apiFailureData();
    }
    public function delete(AdminRequest $request)
    {
        $data = $request->validated();
        $result = $this->service->delete($data['admin_id']);
        return $result ? apiSuccessData() : apiFailureData();
    }
    public function detail(AdminRequest $request)
    {
        $data = $request->validated();
        $result = $this->service->detail($data['admin_id']);
        return $result ? apiSuccessData($result) : apiFailureData();
    }
    public function list(AdminRequest $request)
    {
        $keyword = $request->input('keyword') ?? '';
        $page = $request->input('page') ?? 1;
        $pageSize = $request->input('pageSize') ?? PAGESIZE;
        $order = $request->input('orderType') ?? 'desc';
        $field = $request->input('fieldName') ?? 'admin_id';
        $list = $this->service->findAll($keyword, [$field => $order], ['*'], true, $page, $pageSize);
        $total = $this->service->count($keyword);
        $data = ['data' => $list, 'total' => $total];
        $data['conf'] = conf('admin_gender')+ conf( 'admin_status');
        return apiSuccessData($data);
    }

}
