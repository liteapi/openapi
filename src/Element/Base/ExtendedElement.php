<?php

namespace Liteapi\Openapi\Element\Base;

use Liteapi\Openapi\Element\Attribute\Omit;

abstract class ExtendedElement extends Element
{

    #[Omit]
    public array $extendedProperties = [];

    public static function load(array $config = []): static
    {
        $element = parent::load($config);
        foreach ($config as $name => $value) {
            if (str_starts_with($name, 'x-')) {
                $element->extendedProperties[$name] = $value;
            }
        }
        return $element;
    }

    public function getValue(): mixed
    {
        return array_merge($this->extendedProperties, parent::getValue());
    }

}