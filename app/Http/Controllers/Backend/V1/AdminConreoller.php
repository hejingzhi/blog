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
}
