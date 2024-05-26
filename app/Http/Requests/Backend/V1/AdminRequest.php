<?php

namespace App\Http\Requests\Backend\V1;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;


class AdminRequest extends BaseRequest{

    public function rules()
    {
        $commonRule = [
            'username' => ['bail', 'required', 'max:20', 'unique:admin,username'],
            'name' => ['bail', 'required', 'max:20'],
            'phone' => ['bail', 'required', phoneRegex()],
            'email' => ['bail', 'required', 'email'],
            'picture' => ['bail', 'nullable', 'max:255'],
            'status' => ['bail', 'required', Rule::in([0, 1])],
            'gender' => ['bail', 'required', Rule::in([0, 1])],
        ];

        $create= [
            'password' => ['bail', 'required', passwordRegex()],
        ];

        $update = [
            'admin_id' => ['bail', 'required', 'integer','exists:admin'],
            'password' => ['bail', 'nullable', passwordRegex()]
        ];

        $idRule =[
            'admin_id' => ['bail', 'required', 'integer','exists:admin'],
        ];

        $rules = [
            'create' => array_merge($commonRule, $create),
            'update' => array_merge($commonRule, $update),
            'delete' => $idRule,
            'detail' => $idRule,

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
            'admin_id' => '管理员ID',
            'username' => '用户名',
            'name' => '姓名',
            'password' => '密码（必须同时包含字母和数字且不低于8位）',
            'phone' => '手机号',
            'gender' => '性别',
            'status' => '状态',
            'picture' => '照片',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
}