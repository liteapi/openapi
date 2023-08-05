<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Attribute\Map;
use Liteapi\Openapi\Element\Attribute\Required;
use Liteapi\Openapi\Element\Base\ExtendedElement;

class Discriminator extends ExtendedElement
{

    public function __construct(
        #[Required]
        public ?string $propertyName = null,
        #[Required] //TODO: is so?
        #[Map('string', 'string')]
        public ?array $map = null
    )
    {
    }

}