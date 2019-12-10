<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'txtEmail' => 'required|email',
            'txtPass' => 'required'
        ];
    }

    //hàm thông báo lỗi
    public function messages()
    {
        return [
            'txtEmail.required' => "Vui lòng nhập Email",
            'txtEmail.email' => "Định dạng email không đúng",
            'txtPass.required' => "Vui lòng nhập mật khẩu"
        ];
    }
}
