<?php

    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Http\Exceptions\HttpResponseException;
    
    class BaseRequest extends FormRequest
    {
        public function withValidator($validator)
        {
            $validator->after(function ($validator) {
                $firstError = $validator->errors();
                $firstError = json_decode(json_encode($firstError), true);
                if ($firstError) {
                    throw new HttpResponseException(response(apiFailureData('操作失败',$firstError)));
                }
            });
        }
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize()
        {
            return true;
        }
    
        public function rules()
        {
            return [
    
            ];
        }
    }
    