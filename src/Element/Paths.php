<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Attribute\Map;
use Liteapi\Openapi\Element\Base\ExtendedElement;
use Liteapi\Openapi\Exception\NodeValidationException;

class Paths extends ExtendedElement
{

    public function __construct(
        #[Map('string', Path::class)]
        public ?array $paths = null
    )
    {
    }

    public function validate(): void
    {
        parent::validate();
        if (is_array($this->paths)) {
            foreach (array_keys($this->paths) as $key) {
                if (!str_starts_with($key,'/')) {
                    throw new NodeValidationException($this->getClassName(), 'paths' ,"must start with '/'");
                }
            }
        }
    }

}