<?php

namespace App\Services\Order;

use App\Entities\Order;
use App\Repositories\OrderProductRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Validators\OrderProductValidator;
use App\Validators\OrderValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class OrderCreate
{

    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var OrderProductRepository
     */
    protected $orderProductRepository;

    /**
     * @var OrderValidator
     */
    protected $orderValidator;

    /**
     * @var OrderProductValidator
     */
    protected $orderProductValidator;

    /**
     * OrderCreate constructor.
     *
     * @param OrderRepository $orderRepository
     * @param ProductRepository $productRepository
     * @param OrderProductRepository $orderProductRepository
     * @param OrderValidator $orderValidator
     * @param OrderProductValidator $orderProductValidator
     */
    public function __construct(
        OrderRepository $orderRepository,
        ProductRepository $productRepository,
        OrderProductRepository $orderProductRepository,
        OrderValidator $orderValidator,
        OrderProductValidator $orderProductValidator
    )
    {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->orderProductRepository = $orderProductRepository;
        $this->orderValidator = $orderValidator;
        $this->orderProductValidator = $orderProductValidator;
    }

    /**
     * Создание заказа
     *
     * @param array $params
     *
     * @return Order
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     **/
    public function call($params)
    {
        $orderParams = ["name" => $params["name"], "email" => $params["email"]];

        $this->orderValidator->with($orderParams)->passesOrFail(ValidatorInterface::RULE_CREATE);

        $orderProductParams = array_map(function ($item) {

            $product = $this->productRepository->find($item["product_id"]);

            return [
                "product_id" => $product["id"],
                "price" => $product["price"],
                "amount" => $item["amount"]
            ];
        }, $params["cart"]);

        $orderParams["total"] = $this->calcTotal($orderProductParams);

        $order = $this->orderRepository->create($orderParams);

        $this->createOrderProduct($order, $orderProductParams);

        return $order;
    }

    /**
     * Записываем состав заказа
     *
     * @param Order $order
     * @param array $orderProducts
     *
     * @return void
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    private function createOrderProduct($order, $orderProducts)
    {
        foreach ($orderProducts as $orderProduct) {

            $orderProduct["order_id"] = $order["id"];

            $this->orderProductValidator->with($orderProduct)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $this->orderProductRepository->create($orderProduct);
        }
    }

    /**
     * Считаем стоимость заказа
     *
     * @param array $cart
     *
     * @return integer
     **/
    private function calcTotal($cart)
    {
        return array_reduce($cart, function ($carry, $item) {

            return $carry + ($item["price"] * $item["amount"]);
        }, 0);
    }
}