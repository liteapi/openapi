<?php

namespace Liteapi\Openapi\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD| Attribute::TARGET_FUNCTION)]
class Description
{

    public function __construct(
        public string $description
    )
    {
    }

}