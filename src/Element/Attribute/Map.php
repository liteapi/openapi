<?php

namespace Liteapi\Openapi\Element\Attribute;

use Attribute;
use Liteapi\Openapi\Element\Base\Element;
use Liteapi\Openapi\Exception\AttributeNodeValidationException;
use Liteapi\Openapi\Exception\ValidationException;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Map
{

    protected array $valueTypes;

    public function __construct(
        protected string $keyType,
        string|array $valueTypes
    )
    {
        if (is_string($valueTypes)) {
            $this->valueTypes = [$valueTypes];
        }
    }

    public function validate(array $map): void
    {
        foreach ($map as $key => $value) {
            if ($this->keyType === 'string') {
                if (!is_string($key)) {
                    throw new AttributeNodeValidationException('The key value ' . gettype($key) . ' is not type of string');
                }
            } elseif ($this->keyType === 'int') {
                if (!is_int($key)) {
                    throw new AttributeNodeValidationException('The key value ' . gettype($key) . ' is not type of int');
                }
            } else {
                throw new AttributeNodeValidationException('Key must be either int or string');
            }

            $type = gettype($value);
            if ($type === 'object') {
                /** @var object $type */
                $className = $type::class;
                $type = $className;
            }
            if (!in_array($type, $this->valueTypes)) {
                throw new ValidationException(sprintf('Value should be of type (types) %s, but found type %s',
                    implode(', ', $this->valueTypes), $type));
            }
        }
    }

    public function convertValue(array $map): array
    {
        $newMap = [];
        foreach ($map as $name => $item) {
            if ($item instanceof Element) {
                $newMap[$name] = $item->getValue();
            } else {
                $newMap[$name] = $item;
            }
        }
        return $newMap;
    }

}