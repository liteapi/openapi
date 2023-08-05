<?php

namespace Liteapi\Openapi\Element;

use Liteapi\Openapi\Element\Attribute\ArrayList;
use Liteapi\Openapi\Element\Attribute\SpecificFieldName;
use Liteapi\Openapi\Element\Base\ExtendedElement;

class Path extends ExtendedElement
{

    public function __construct(
        #[SpecificFieldName('$ref')]
        public ?string $ref = null,
        public ?string $summary = null,
        public ?string $description = null,
        public ?Operation $get = null,
        public ?Operation $put = null,
        public ?Operation $post = null,
        public ?Operation $delete = null,
        public ?Operation $options = null,
        public ?Operation $head = null,
        public ?Operation $patch = null,
        public ?Operation $trace = null,
        #[ArrayList(Server::class)]
        public ?array $servers = null,
        #[ArrayList([Parameter::class, Reference::class])]
        public ?array $parameters = null
    )
    {
    }



}