<?php

namespace Liteapi\Openapi\Element\Attribute;

use Attribute;
use Liteapi\Openapi\Exception\AttributeNodeValidationException;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ArrayList extends Map
{

    public function __construct(string|array $valueTypes)
    {
        parent::__construct('int', $valueTypes);
    }

    public function validate(array $map): void
    {
        if (false === array_is_list($map)) {
            throw new AttributeNodeValidationException('Array value must list');
        }
        parent::validate($map);
    }

}