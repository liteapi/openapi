<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Attribute\SpecificFieldName;
use Liteapi\Openapi\Element\Attribute\Uri;
use Liteapi\Openapi\Element\Base\Element;

class Reference extends Element
{

    public function __construct(
        #[Uri]
        #[SpecificFieldName('$ref')]
        public ?string $ref = null,
        public ?string $summary = null,
        public ?string $description = null
    )
    {
    }

}