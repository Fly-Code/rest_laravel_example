<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OrderProduct.
 *
 * @package namespace App\Entities;
 */
class OrderProduct extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * Таблица состава заказа
     *
     * @var string
     */
    protected $table = "order_product";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["order_id", "product_id", "amount", "price"];

}
