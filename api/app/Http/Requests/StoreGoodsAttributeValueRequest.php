<?php

namespace App\Http\Requests;

use App\Models\Goods;
use App\Models\GoodsAttributeDefinition;
use App\Models\GoodsAttributeValueFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Validator;

class StoreGoodsAttributeValueRequest extends FormRequest
{
    protected Goods|null $goods;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->goods = Goods::find($this->request->get("goods_id"));
        return Auth::check() &&
            $this->request->get("goods_id") == \request()->goodsId &&
            $this->goods?->author_id == Auth::id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "goods_id" => "required|exists:goods,id",
            "attribute_id" => "required|exists:attributes,id",
            "value" => "required"
        ];
    }

    public function after(): array
    {
        return [
            //validate value by type
            function(Validator $validator) {
                $attribute = GoodsAttributeDefinition::where([
                    "id" => \Illuminate\Support\Facades\Request::post("attribute_id"),
                ])->first();
                $valueClass = GoodsAttributeValueFactory::getClassByType($attribute->type);
                call_user_func($valueClass . "::validateValue",
                    $validator,
                    \Illuminate\Support\Facades\Request::post("value"), $attribute
                );
            },
        ];
    }

}
