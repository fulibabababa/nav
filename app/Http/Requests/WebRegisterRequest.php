<?php

namespace App\Http\Requests;

use App\Models\Category;
use App\Models\Link;
use Illuminate\Foundation\Http\FormRequest;

class WebRegisterRequest extends FormRequest
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
            'web_name'    => ['required', 'string'],
            'link'        => [
                'required', 'url',
                function ($attribute, $value, $fail) {
                    $exists = Link::where('top_domain', url_top_domain($value))->exists();
                    if ($exists) {
                        $fail('该域名已添加');
                    }
                },
            ],
            'category_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = Category::where(['id' => $value, 'can_register' => 1])->exists();
                    if (!$exists) {
                        $fail('无法添加到该分类');
                    }
                },
            ]
        ];
    }

    public function attributes()
    {
        return [
            'web_name'    => '网站名称',
            'link'        => '网站主页',
            'category_id' => '分类',
        ];
    }
}
