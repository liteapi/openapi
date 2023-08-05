<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Attribute\Required;
use Liteapi\Openapi\Element\Attribute\Uri;
use Liteapi\Openapi\Element\Base\ExtendedElement;
use Liteapi\Openapi\Exception\NodeValidationException;
use ReflectionClass;

class License extends ExtendedElement
{

    public function __construct(
        #[Required]
        public ?string $name = null,
        #[Uri]
        public ?string $url = null,
        public ?string $identifier = null,
    )
    {
    }

    public function validate(): void
    {
        parent::validate();
        if ($this->url !== null && $this->identifier !== null) {
            throw new NodeValidationException((new ReflectionClass(__CLASS__))->getShortName(), 'url',
                'is mutually exclusive of the identifier property');
        }
    }

}