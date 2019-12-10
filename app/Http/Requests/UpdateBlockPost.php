<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlockPost extends FormRequest
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
            'titlePost' => 'required|max:200|min:5',
            'sapoPost' => 'required|max:200|min:5',
            'languagePost' => 'required|numeric',
            'categoryPost' => 'required|numeric',
            'tagsPost' => 'required',
            'contentPost' => 'required|min:5',
            'statusPost' => 'required|numeric'
        ];
    }
    public function messages()
    {
        return [
            'titlePost.required' => 'Vui lòng nhập tiêu đề bài viết',
            'titlePost.max' => 'Tiêu đề bài viết không lớn hơn :max kí tự',
            'titlePost.min' => 'Tiêu đề bài viết không lớn hơn :min kí tự',

            'sapoPost.required' => 'Vui lòng nhập miêu tả bài viết',
            'sapoPost.max' => 'Miêu tả bài viết không lớn hơn :max kí tự',
            'sapoPost.min' => 'Miêu tả bài viết không lớn hơn :min kí tự',

            'languagePost.required' => 'Vui lòng chọn ngôn ngữ bài viết',
            'languagePost.numeric' => 'Ngôn ngữ không tồn tại',

            'categoryPost.required' => 'Vui lòng chọn danh mục bài viết',
            'categoryPost.numeric' => 'Danh mục không tồn tại không tồn tại',

            'tagsPost.required' => 'Vui lòng chọn tags bài viết',

            'contentPost.required' => 'Vui lòng nhập nội dung bài viết',
            'contentPost.min' => 'Nội dung không nhỏ hơn :min kí tự',

            'statusPost.required' => "Vui lòng chọn trạng thái",
            'statusPost.numeric' => "Lỗi trang thái"
        ];
    }
}
