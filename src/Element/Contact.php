<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Attribute\Email;
use Liteapi\Openapi\Element\Attribute\Uri;
use Liteapi\Openapi\Element\Base\ExtendedElement;

class Contact extends ExtendedElement
{

    public function __construct(
        public ?string $name = null,
        #[Uri]
        public ?string $url = null,
        #[Email]
        public ?string $email = null,
    )
    {
    }

}