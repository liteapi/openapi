<?php

namespace Liteapi\Openapi\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD| Attribute::TARGET_FUNCTION)]
class Summary
{

    public function __construct(
        public string $summary
    )
    {
    }

}