<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Attribute\Map;
use Liteapi\Openapi\Element\Base\ExtendedElement;

class Encoding extends ExtendedElement
{

    public function __construct(
        public ?string $contentType = null,
        #[Map('string', [Header::class, Reference::class])]
        public ?array $headers = null,
        public ?string $style = null,
        public ?bool $explode = null,
        public ?bool $allowReserved = null,
    )
    {
    }

}