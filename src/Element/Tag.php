<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Attribute\Required;
use Liteapi\Openapi\Element\Base\Element;

class Tag extends Element
{

    public function __construct(
        #[Required]
        public ?string $name = null,
        public ?string $description = null,
        public ?ExternalDocumentation $externalDoc = null
    )
    {
    }

}