<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGoodsAttributeValueRequest;
use App\Models\Category;
use App\Models\Goods;
use App\Models\GoodsAttributeDefinition;
use App\Models\GoodsAttributeDictionaryDefinition;
use App\Models\GoodsAttributeValueFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
            $responseData[$definition->id] = GoodsAttributeValueFactory::getValueJoinFor(
                $definition->id,
                $definition->type,
                $goodsId,
            );
        }

        return ["data" => $responseData];
    }

    public function attributesForCategory(Category $category)
    {
        return ["data" => GoodsAttributeDefinition::getAttributesForCategory($category)];
    }

    public function getDictionaryDefinitions(int $id)
    {
        $definition = GoodsAttributeDefinition::findOrFail($id);
        $definitions = GoodsAttributeDictionaryDefinition::where(["attribute_id" => $definition->id])->get();

        return ["data" => $definitions];
    }

    /**
     * @throws \Exception
     */
    public function storeGoodsAttribute(StoreGoodsAttributeValueRequest $request)
    {
        $data = $request->validated();
        $goods = Goods::findOrFail($data["goods_id"]);
        $attributeDefinition = GoodsAttributeDefinition::findOrFail($data["attribute_id"]);

        $attributeValue = GoodsAttributeValueFactory::getValueFor(
            $data["attribute_id"],
            $attributeDefinition->type,
            $data["goods_id"]
        ) ?? GoodsAttributeValueFactory::newGoodsAttributeValue($attributeDefinition->type);
        $attributeValue->value = $data["value"];
        $attributeValue->goods_id = $data["goods_id"];
        $attributeValue->attribute_id = $data["attribute_id"];
        $attributeValue->save();

        return $attributeValue;
    }

}
