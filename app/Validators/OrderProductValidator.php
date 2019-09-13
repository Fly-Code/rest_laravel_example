<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class OrderProductValidator.
 *
 * @package namespace App\Validators;
 */
class OrderProductValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'product_id' => 'required',
            'order_id' => 'required',
            'amount' => 'required',
            'price' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
