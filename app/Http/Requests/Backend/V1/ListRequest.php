<?php

namespace App\Http\Requests\Backend\V1;

use App\Http\Requests\BaseRequest;
use App\Http\Services\V1\Common\CommonFieldService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ListRequest extends BaseRequest
{
    public function prepareForValidation()
    {
        if ($this->has('keyword')) {
            $keyword = trimKeyword($this->input('keyword'));
            $this->merge(['keyword' => $keyword]);
        }

        if ($this->has('pageSize')) {
            $pageSize = intval($this->input('pageSize'));
            $this->input('pageSize') > MAXPAGESIZE && $pageSize = MAXPAGESIZE;
            $this->merge(['pageSize' => $pageSize]);
        }

        $this->merge(['orderType' => in_array($this->input('orderType'), ['asc', 'desc']) ? $this->input('orderType') : null]);
    }
}
