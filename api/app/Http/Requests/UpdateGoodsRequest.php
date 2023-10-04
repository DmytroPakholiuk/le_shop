<?php

namespace App\Http\Requests;

use App\Models\Goods;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateGoodsRequest extends FormRequest
{
    protected Goods $goods;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->goods = Goods::find($this->request->get("id"));
        return Auth::check() && $this?->goods->author_id == Auth::id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "id" => "exists:goods,id",
            "name" => "string|required|max:255",
            "description" => "string",
            "price" => "required|decimal:0,2",
            "available" => "required|boolean",
            "category_id" => "exists:categories,id",
        ];
    }

}
