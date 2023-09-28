<?php

namespace App\Models\FilterModels;

use App\Models\Goods;
use Illuminate\Http\Request;

class FilterGoods extends Goods implements FilterModelInterface
{
    use FilterModelTrait;

//    protected Request $request;

    public function filterRules(): array
    {
        return [
            "id" => ["id", "="],
            "name" => ["name", "like"],
            "description" => ["description", "like"],
            "price-from" => ["price", ">="],
            "price-to" => ["price", "<="],
            "available" => ["available", "="],
            "category_id" => ["category_id", "="],
            "author_id" => ["author_id", "="],
            "created_at-from" => ["created_at", ">"],
            "created_at-to" => ["created_at", "<"],
            "updated_at-from" => ["updated_at", ">"],
            "updated_at-to" => ["updated_at", "<"]
        ];
    }

    public function __construct(Request $request, array $attributes = [])
    {
        $this->request = $request;
        parent::__construct($attributes);
    }
}
