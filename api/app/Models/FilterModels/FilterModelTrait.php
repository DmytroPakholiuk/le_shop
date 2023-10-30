<?php

namespace App\Models\FilterModels;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * This trait is created to easily implement the business-logic of filtering.
 * The FilterModel you create should implement filterRules() method as described.
 * It should also implement FilterModelInterface for better predictability //??or should it?
 */
trait FilterModelTrait
{
    protected Request $request;
    protected int $defaultPage = 1;
    protected int $defaultPerPage = 20;

    /**
     * maximum number of records you can query, so that no one can hang the database by querying all the records
     * @var int
     */
    protected int $maxPerPage = 200;

    /**
     * This method is to be overwritten in your actual model. It should return array of structure:
     * ["GET_parameter_name" => ["model_attribute_name", "operator"]]
     * @return array
     */
    public function filterRules(): array
    {
        return [];
    }

    /**
     * This method returns a QueryBuilder with applied filters from filterRules() and limit/offset for pagination.
     * You may also add orderBy(), apply get() or count() method to get the results.
     * You should ensure that the data from request is validated
     * @return Builder
     */
    public function search(): Builder
    {
        $request = $this->request;
        $pageNumber = $request->get("page") ?? $this->defaultPage;
        $perPage = is_integer($request->get("per_page")) && $request->get("per_page") < $this->maxPerPage
            ? $request->get("per_page")
            : $this->defaultPerPage;

        $filterRules = $this->filterRules();
        $getParams = array_keys($filterRules);

        $data = $request->only($getParams);

        $query = DB::table($this->getTable())->select($this->getFillable());

        /**
         * @var array $rule
         */
        foreach ($filterRules as $getParam => $rule){
            $this->resolveFilter($query, $rule[0], $rule[1], $data[$getParam] ?? null);
        }

        $offset = $perPage * ($pageNumber - 1);
        $query->offset($offset);
        $query->limit($perPage);

        return $query;
    }

    /**
     * @throws \Exception
     */
    protected function resolveFilter(Builder $query, string $column, string $operator, mixed $value = null): void
    {
        if (in_array($operator, $query->operators)){
            if ($value !== null){
                if (in_array($operator, ["like", "ilike", "like binary", "not like"])){
                    $value = "%" . $value . "%";
                }
                $query->where($column, $operator, $value);
            }
        } else {
            throw new \Exception("The operator \"{$operator}\" from your filter rules is not a valid operator.
                Refer to Builder::operators to get a list of correct operators");
        }
    }
}
