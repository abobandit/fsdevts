<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0.01',
            'category_id' => 'sometimes|required|exists:categories,id',
        ];
    }
}
