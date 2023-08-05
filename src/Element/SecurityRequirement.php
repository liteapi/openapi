<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Base\Element;
use Liteapi\Openapi\Exception\NodeValidationException;

class SecurityRequirement extends Element
{

    public function __construct(
        public ?array $fields = null //TODO: check if maps can handle maps inside
    )
    {
    }

    public function validate(): void
    {
        parent::validate();
        $className = $this->getClassName();
        foreach ($this->fields as $name => $items) {
            if (!is_string($name)) {
                throw new NodeValidationException($className, 'fields',
                    'must have string keys');
            }
            if (!array_is_list($items)) {
                throw new NodeValidationException($className, 'fields',
                    'must has list of string values in key ' . $name);
            }
            foreach ($items as $item) {
                if (!is_string($item)) {
                    throw new NodeValidationException($className, 'fields',
                        'must has list of string values in key ' . $name);
                }
            }

        }
    }

}