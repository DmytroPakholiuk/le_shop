<?php

namespace App\Http\Requests;

use App\Models\Goods;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateGoodsRequest extends FormRequest
{
    protected $goods;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "name" => "string|required|max:255",
            "description" => "string",
            "price" => "required|decimal:2",
            "available" => "required|boolean",
            "category_id" => "exists:categories,id",
        ];
    }

}
