<?php

namespace App\Http\Controllers\API\V1;

use App\Criteria\PriceBetweenCriteria;
use App\Http\Requests\ProductIndexRequest;
use App\Repositories\ProductRepository;
use App\Validators\ProductValidator;

/**
 * Class ProductsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ProductsController extends ApiController
{
    /**
     * @var ProductRepository
     */
    protected $repository;

    /**
     * @var ProductValidator
     */
    protected $validator;

    /**
     * ProductsController constructor.
     *
     * @param ProductRepository $repository
     * @param ProductValidator $validator
     */
    public function __construct(ProductRepository $repository, ProductValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Список товаров.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductIndexRequest $request)
    {
        $this->repository->pushCriteria(new PriceBetweenCriteria($request));
        return response()->json($this->repository->paginate(20));
    }

    /**
     * Просмотр одного товара.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->repository->find($id);

        return response()->json([
            'data' => $product,
        ]);
    }
}
