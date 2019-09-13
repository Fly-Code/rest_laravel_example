<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class PriceBetweenCriteria.
 *
 * @package namespace App\Criteria;
 */
class PriceBetweenCriteria implements CriteriaInterface
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param Request             $request
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {

        if (!$this->request->has('price_from') || !$this->request->has('price_to')) {

            return $model;
        }

        $model = $model->whereBetween('price', [$this->request->get('price_from'), $this->request->get('price_to')]);

        return $model;
    }
}
