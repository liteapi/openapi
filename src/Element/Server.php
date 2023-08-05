<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Attribute\Map;
use Liteapi\Openapi\Element\Attribute\Required;
use Liteapi\Openapi\Element\Base\ExtendedElement;

class Server extends ExtendedElement
{

    public function __construct(
        #[Required]
        public ?string $url = null,
        public ?string $description = null,
        #[Map('string', ServerVariable::class)]
        public array $variables = []
    )
    {
    }
}