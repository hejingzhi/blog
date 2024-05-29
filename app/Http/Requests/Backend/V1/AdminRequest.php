<?php

namespace App\Http\Requests\Backend\V1;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;


class AdminRequest extends BaseRequest{

    public function rules()
    {
        $admin_id = $this->input('admin_id');
        $commonRule = [
            'admin_username' => ['bail', 'required', 'max:20', 'unique:admin,admin_username,'.$admin_id.',admin_id'],
            'admin_name' => ['bail', 'required', 'max:20'],
            'admin_phone' => ['bail', 'required', phoneRegex()],
            'admin_email' => ['bail', 'required', 'email'],
            'admin_picture' => ['bail', 'nullable', 'max:255'],
            'admin_status' => ['bail', 'required', Rule::in([0, 1])],
            'admin_gender' => ['bail', 'nullable', Rule::in([0, 1])],
        ];

        $create= [
            'admin_password' => ['bail', 'required', passwordRegex()],
        ];
        $update = [
            'admin_id' => ['bail', 'required', 'integer','exists:admin'],
            'admin_password' => ['bail', 'nullable', passwordRegex()]
        ];

        $idRule =[
            'admin_id' => ['bail', 'required', 'integer','exists:admin,admin_id,deleted_at,NULL'],
        ];
        $rules = [
            'create' => array_merge($commonRule, $create),
            'update' => array_merge($update,$commonRule ),
            'delete' => $idRule,
            'detail' => $idRule,
            'list' => [],

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
            'admin_username' => '用户名',
            'admin_name' => '姓名',
            'admin_password' => '密码（必须同时包含字母和数字且不低于8位）',
            'admin_phone' => '手机号',
            'admin_gender' => '性别',
            'admin_status' => '状态',
            'admin_picture' => '照片',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
}