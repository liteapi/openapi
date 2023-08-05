<?php

namespace Liteapi\Openapi\Generator\Utils;

use Liteapi\Openapi\Element\Operation;

class RouteObject
{

    public function __construct(
        public string $pathName,
        /** @var array<string,Operation> */
        public array $operations
    )
    {
    }

}