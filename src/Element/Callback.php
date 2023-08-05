<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Attribute\Map;
use Liteapi\Openapi\Element\Base\ExtendedElement;

class Callback extends ExtendedElement
{

    public function __construct(
        #[Map('string', [Path::class, Reference::class])]
        public ?array $expressions = null
    )
    {
    }

}