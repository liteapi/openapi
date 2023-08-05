<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Attribute\Required;
use Liteapi\Openapi\Element\Attribute\Uri;
use Liteapi\Openapi\Element\Base\Element;

class ExternalDocumentation extends Element
{

    public function __construct(
        #[Required]
        #[Uri]
        public ?string $url = null,
        public ?string $description = null,
    )
    {
    }

}