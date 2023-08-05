<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Attribute\Map;
use Liteapi\Openapi\Element\Base\ExtendedElement;
use Liteapi\Openapi\Exception\NodeValidationException;

class Responses extends ExtendedElement
{

    public function __construct(
        #[Map('string', [Response::class, Reference::class])]
        public ?array $fields = null
    )
    {
    }

    public function validate(): void
    {
        parent::validate();
        if (isset($this->fields)) {
            $keys = array_keys($this->fields);
            foreach ($keys as $key) {
                if (preg_match('/^(default)|[12345][\dX]{2}$/', $key) !== 1) {
                    throw new NodeValidationException($this->getClassName(), 'fields',
                        'key must be default or [1-5][0-9X]{2}');
                }
            }
        }
    }

}