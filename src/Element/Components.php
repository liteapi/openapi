<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Attribute\Map;
use Liteapi\Openapi\Element\Base\ExtendedElement;

class Components extends ExtendedElement
{

    public function __construct(
        #[Map('string', Schema::class)]
        public ?array $schemas = null,
        #[Map('string', [Response::class, Reference::class])]
        public ?array $responses = null,
        #[Map('string', [Parameter::class, Reference::class])]
        public ?array $parameters = null,
        #[Map('string', [Example::class, Reference::class])]
        public ?array $examples = null,
        #[Map('string', [RequestBody::class, Reference::class])]
        public ?array $requestBodies = null,
        #[Map('string', [Header::class, Reference::class])]
        public ?array $headers = null,
        #[Map('string', [SecurityScheme::class, Reference::class])]
        public ?array $securitySchemes = null,
        #[Map('string', [Link::class, Reference::class])]
        public ?array $links = null,
        #[Map('string', [Callback::class, Reference::class])]
        public ?array $callbacks = null,
        #[Map('string', [Path::class, Reference::class])]
        public ?array $pathItems = null,
    )
    {
    }

}