<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\GoodsAttributeDefinition;
use App\Models\GoodsAttributeValueFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{

    /**
     * Display a listing of the resource.
     * @throws \Exception
     */
    public function indexForGoods(Request $request, $goodsId)
    {
        $goods = Goods::findOrFail($goodsId);
        $attributeDefinitions = GoodsAttributeDefinition::getAttributesForCategory($goods->category);

        $responseData = [];
        foreach ($attributeDefinitions as $definition){
            $responseData[$definition->id] = GoodsAttributeValueFactory::getValueFor($definition->id, $definition->type, $goodsId);
        }

        return ["data" => $responseData];
    }
}
