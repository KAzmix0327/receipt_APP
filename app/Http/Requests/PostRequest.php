<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        // storeかupdateかを取得
        $route = $this->route()->getName();

        $rule = [
            'name' => 'required|string|max:10',
            'price' => 'required|integer|max:999999',
            'body' => 'required|string|max:300',
            // 'image' => 'required|file|image|mimes:jpg,png',
        ];
        if (
            $route === 'posts.store' ||
            ($route === 'posts.update' && $this->file('image'))
        ) {
            $rule['image'] = 'required|file|image|mimes:jpg,png';
        }

        return $rule;
    }
}
