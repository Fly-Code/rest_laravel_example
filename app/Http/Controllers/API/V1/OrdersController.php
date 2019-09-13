<?php

namespace App\Http\Controllers\API\V1;

use App\Services\Order\OrderCreate;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\OrderCreateRequest;

/**
 * Class OrdersController.
 *
 * @package namespace App\Http\Controllers;
 */
class OrdersController extends ApiController
{
    /**
     * Создание заказа.
     *
     * @param  OrderCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(OrderCreateRequest $request, OrderCreate $orderCreate)
    {
        try {

            $product = $orderCreate->call($request->all());

            $response = [
                'message' => 'Заказ создан.',
                'data' => $product->toArray(),
            ];

            return response()->json($response);
        } catch (ValidatorException $e) {

            return response()->json([
                'error' => true,
                'message' => $e->getMessageBag()
            ]);
        }
    }
}
