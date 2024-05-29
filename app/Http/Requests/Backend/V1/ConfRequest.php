<?php

namespace App\Http\Requests\Backend\V1;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ConfRequest extends BaseRequest
{
    public function rules()
    {
        $confContent = json_decode($this->input('conf_content'), true);
        $confKey = $this->input('conf_key');
        $confKey = isset($confContent[$confKey]) ? $confKey : '';
        $conf_id = $this->input('conf_id');
        $commonRule = [
            'conf_name' => ['bail', 'required', 'max:50'],
            'conf_key' => ['bail', 'required', 'max:50', 'unique:conf,conf_key,'.$conf_id.',conf_id', Rule::in($confKey)],
            'conf_type' => ['bail', 'required', Rule::in([1, 2, 3, 4])],
            'conf_content' => ['bail', 'required', 'json'],
        ];
        $idRule = [
            'conf_id' => ['bail', 'required', 'exists:conf,conf_id,deleted_at,NULL'],
        ];
        $rules = [
            'create' => array_merge($commonRule, []),
            'update' => array_merge($idRule, $commonRule, []),
            'delete' => array_merge($idRule, []),
            'detail' => array_merge($idRule, []),
            'getFromOut' => ['keys' => ['bail', 'required', 'regex:/^[\w,]+$/']],
        ];

        $actionMethod = $this->route()->getActionMethod();
        $actionMethodExists = in_array($actionMethod, array_keys($rules));
        return $actionMethodExists ? $rules[$actionMethod] : ['ruleMethod' => 'required'];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'conf_id' => '编号',
            'conf_name' => '名称',
            'conf_key' => '查询键',
            'conf_type' => '类型',
            'conf_content' => '内容',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'keys' => '配置键集合',
        ];
    }
}
