<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Attribute\Required;
use Liteapi\Openapi\Element\Attribute\Uri;
use Liteapi\Openapi\Element\Base\ExtendedElement;

class Info extends ExtendedElement
{

    public function __construct(
        #[Required]
        public ?string $title = null,
        #[Required]
        public ?string $version = null,
        public ?string $summary = null,
        public ?string $description = null,
        #[Uri]
        public ?string $termOfService = null,
        public ?Contact $contact = null,
        public ?License $license = null,
    )
    {
    }

}