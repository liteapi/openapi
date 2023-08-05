<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Base\ExtendedElement;

class Schema extends ExtendedElement
{

    public function __construct(
        public ?Discriminator $discriminator = null,
        public ?Xml $xml = null,
        public ?ExternalDocumentation $externalDocs = null,
        public ?array $example = null
    )
    {
    }


    public function validate(): void
    {
        parent::validate();
        if ($this->example !== null) {
            trigger_error(sprintf("Property '%s' of node '%s' %s",
                $this->getClassName(), 'example', 'is deprecated'), E_USER_DEPRECATED);
        }
    }

}