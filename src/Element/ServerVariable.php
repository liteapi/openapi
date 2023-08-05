<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Attribute\ArrayList;
use Liteapi\Openapi\Element\Attribute\Required;
use Liteapi\Openapi\Element\Base\ExtendedElement;
use Liteapi\Openapi\Exception\NodeValidationException;

class ServerVariable extends ExtendedElement
{

    public function __construct(
        #[Required]
        public ?string $default = null,
        #[ArrayList('string')]
        public ?array $enum = null,
        public ?string $description = null
    )
    {
    }

    public function validate(): void
    {
        parent::validate();
        if (is_array($this->enum) && empty($this->enum)) {
            throw new NodeValidationException((new \ReflectionClass(__CLASS__))->getShortName(),
                'enum', 'must not be empty');
        }
    }

}