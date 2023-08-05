<?php

namespace Liteapi\Openapi\Element\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class SpecificFieldName
{

    public function __construct(
        public string $name
    )
    {
    }

}