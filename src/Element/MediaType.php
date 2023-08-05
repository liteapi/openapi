<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Attribute\Map;
use Liteapi\Openapi\Element\Base\ExtendedElement;

class MediaType extends ExtendedElement
{

    public function __construct(
        public ?Schema $schema = null,
        public ?array $example = null, //TODO: is so?
        #[Map('string', [Example::class, Reference::class])]
        public ?array $examples = null,
        #[Map('string', Encoding::class)]
        public ?array $encoding = null,
    )
    {
    }

}