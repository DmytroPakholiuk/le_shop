<?php

namespace App\Models\FilterModels;

use Illuminate\Http\Request;

class FilterCategory extends \App\Models\Category implements FilterModelInterface
{
    use FilterModelTrait;

    public function filterRules(): array
    {
        return [
            "id" => ["id", "="],
            "name" => ["name", "like"],
            "description" => ["description", "like"],
            "status" => ["status", "="],
            "parent_id" => ["parent_id", "="],
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
