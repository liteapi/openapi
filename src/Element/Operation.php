<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Attribute\ArrayList;
use Liteapi\Openapi\Element\Attribute\Map;
use Liteapi\Openapi\Element\Base\ExtendedElement;

class Operation extends ExtendedElement
{

    public function __construct(
        #[ArrayList('string')]
        public ?array $tags = null,
        public ?string $summary = null,
        public ?string $description = null,
        public ?ExternalDocumentation $externalDocs = null,
        public ?string $operationId = null,
        #[ArrayList([Parameter::class, Reference::class])]
        public ?array $parameters = null,
        public null|RequestBody|Reference $requestBody = null,
        public ?Responses $responses = null,
        #[Map('string', [Callback::class, Reference::class])]
        public ?array $callbacks = null,
        public ?bool $deprecated = null,
        #[ArrayList(SecurityRequirement::class)]
        public ?array $security = null,
        #[ArrayList(Server::class)]
        public ?array $server = null
    )
    {
    }

}