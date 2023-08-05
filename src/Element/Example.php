<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Attribute\Uri;
use Liteapi\Openapi\Element\Base\ExtendedElement;

class Example extends ExtendedElement
{

    public function __construct(
        public ?string $summary = null,
        public ?string $description = null,
        public mixed $value = null,
        #[Uri]
        public ?string $externalValue = null,
    )
    {
    }

}