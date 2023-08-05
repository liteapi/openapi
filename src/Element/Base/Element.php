<?php

namespace Liteapi\Openapi\Element\Base;

use Liteapi\Openapi\Element\Attribute\Email;
use Liteapi\Openapi\Element\Attribute\Map;
use Liteapi\Openapi\Element\Attribute\Omit;
use Liteapi\Openapi\Element\Attribute\Required;
use Liteapi\Openapi\Element\Attribute\ShowNull;
use Liteapi\Openapi\Element\Attribute\SpecificFieldName;
use Liteapi\Openapi\Element\Attribute\Uri;
use Liteapi\Openapi\Element\Attribute\Validation;
use Liteapi\Openapi\Exception\NodeValidationException;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;

abstract class Element
{

    /**
     * Allows loading elements (including nested) from array
     *
     * @param array $config
     * @return static
     * @throws \ReflectionException
     */
    public static function load(array $config = []): static
    {
        $rc = new ReflectionClass(static::class);
        $element = $rc->newInstanceWithoutConstructor();
        $properties = $rc->getProperties();
        foreach ($properties as $property) {
            if (isset($config[$property->getName()])) {
                self::loadPropertyValue($element, $property, $config[$property->getName()]);
            } else {
                $fieldNameAttributes = $property->getAttributes(SpecificFieldName::class);
                /** @var SpecificFieldName $fieldNameAttribute */
                $fieldNameAttribute = $fieldNameAttributes[0]->newInstance();
                if (isset($config[$fieldNameAttribute->name])) {
                    self::loadPropertyValue($element, $property, $config[$fieldNameAttribute->name]);
                }
            }
        }
        return $element;
    }

    protected static function loadPropertyValue(self $element, ReflectionProperty $property, array $config): void
    {
        $types = $property->getType()->getTypes();
        foreach ($types as $type) {
            if (is_subclass_of($type->getName(), self::class)) {
                /** @var self $className */
                $className = $type->getName();
                $property->setValue($element, $className::load($config));
                return;
            }
        }
        $mapAttributes = $property->getAttributes(Map::class, ReflectionAttribute::IS_INSTANCEOF);
        if (isset($mapAttributes[0])) {

            return;
        }
        $property->setValue($element, $config);
    }

    /**
     * Allows to load default value before validation
     * @return void
     */
    protected function loadDefault(): void
    {
    }

    /**
     * Calculating and building Element object returning:
     * if more than one property -> an array of values (key: property name, value: calculated value)
     * if one property and one defined (not null or with ShowNull attribute) -> value of property
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public function getValue(): mixed
    {
        $rc = new ReflectionClass($this::class);
        $properties = $rc->getProperties();
        $data = [];
        $valueProperties = count($properties);
        foreach ($properties as $property) {
            $fieldNameAttributes = $property->getAttributes(SpecificFieldName::class);
            if (isset($fieldNameAttributes[0])) {
                $propertyName = $fieldNameAttributes[0]->newInstance()->name;
            } else {
                $propertyName = $property->getName();
            }
            $omitAttributes = $property->getAttributes(Omit::class);
            if (isset($omitAttributes[0])) {
                $valueProperties--;
                continue;
            }
            $value = $property->getValue($this);
            if ($value !== null) {
                if (is_array($value) && empty($value)) {
                    continue;
                }
                $mapAttributes = $property->getAttributes(Map::class, ReflectionAttribute::IS_INSTANCEOF);
                if (isset($mapAttributes[0])) {
                    /** @var Map $map */
                    $map = $mapAttributes[0]->newInstance();
                    $data[$propertyName] = $map->convertValue($value);
                } else {
                    $data[$propertyName] = $value instanceof Element ? $value->getValue() : $value;
                }
            } else {
                $showNullAttributes = $property->getAttributes(ShowNull::class);
                if (isset($showNullAttributes[0])) {
                    $data[$propertyName] = null;
                }
            }
        }
        if ($valueProperties === 1 && count($data) === 1) {
            return array_pop($data);
        }
        return $data;
    }

    /**
     * Validate Element properties, including nested properties
     *
     * @return void
     * @throws NodeValidationException
     * @throws \Liteapi\Openapi\Exception\AttributeNodeValidationException
     * @throws \Liteapi\Openapi\Exception\ValidationException
     * @throws \ReflectionException
     */
    public function validate(): void
    {
        $this->loadDefault();
        $rc = new ReflectionClass($this::class);
        $properties = $rc->getProperties();
        foreach ($properties as $property) {
            /* Handling #[Omit] */
            $omitAttributes = $property->getAttributes(Omit::class);
            if (isset($omitAttributes[0])) {
                continue;
            }
            $value = $property->getValue($this);
            if ($value !== null) {
                if ($value instanceof Element) {
                    $value->validate();
                } else {
                    /* Handling ALL #[Validation] */
                    $validationAttributes = $property->getAttributes(Validation::class);
                    foreach ($validationAttributes as $validationAttribute) {
                        /** @var Validation $validation */
                        $validation = $validationAttribute->newInstance();
                        $validation->validate($value);
                    }
                    /* Handling #[Email] */
                    $emailAttributes = $property->getAttributes(Email::class);
                    if (isset($emailAttributes[0])) {
                        if (!is_string($value)) {
                            throw new NodeValidationException($rc->getShortName(), $property->getName(),
                                'must be type of string to be email');
                        }
                        self::validateEmail($value);
                        continue;
                    }
                    /* Handling #[Uri] */
                    $urlAttributes = $property->getAttributes(Uri::class);
                    if (isset($urlAttributes[0])) {
                        if (!is_string($value)) {
                            throw new NodeValidationException($rc->getShortName(), $property->getName(),
                                'must be type of string to be url');
                        }
                        self::validateUrl($value);
                        continue;
                    }
                    /* Handling #[Map] and #[ArrayList] */
                    $mapAttributes = $property->getAttributes(Map::class, ReflectionAttribute::IS_INSTANCEOF);
                    if (isset($mapAttributes[0])) {
                        /** @var Map $map */
                        $map = $mapAttributes[0]->newInstance();
                        if (!is_array($value)) {
                            throw new NodeValidationException($rc->getShortName(), $property->getName(),
                                'must be of type array to be a ' . (new ReflectionClass($map))->getShortName());
                        }
                        $map->validate($value);
                    }
                }
            } else {
                $requiredAttributes = $property->getAttributes(Required::class);
                if (isset($requiredAttributes[0])) {
                    throw new NodeValidationException($rc->getShortName(), $property->getName(),
                        'must be not null');
                }
            }
        }
    }

    protected function getClassName(): string
    {
        $rc = new ReflectionClass($this);
        return $rc->getShortName();
    }

    public static function validateUrl(string $url): void
    {
        //filter_var($url, FILTER_SANITIZE_URL)
        //TODO:
    }

    public static function validateEmail(string $email): void
    {
        //TODO:
    }
}