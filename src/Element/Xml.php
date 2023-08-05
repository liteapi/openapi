<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Base\ExtendedElement;

class Xml extends ExtendedElement
{

    public function __construct(
        public ?string $name = null,
        public ?string $namespace = null,
        public ?string $prefix = null,
        public ?bool $attribute = null,
        public ?bool $wrapped = null,
    )
    {
    }

}