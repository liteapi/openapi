<?php

namespace Liteapi\Openapi\Generator\Processor\Base;

use Liteapi\Openapi\Document\OpenApi;

interface GeneratorProcessor
{

    public function process(OpenApi $openApi);

}