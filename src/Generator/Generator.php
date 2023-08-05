<?php

namespace Liteapi\Openapi\Generator;

use Liteapi\Openapi\Document\OpenApi;
use Liteapi\Openapi\Generator\Processor\Base\GeneratorProcessor;

class Generator
{

    public const VERSION_3_1 = '3.1.0';
    public const VERSION_3_0 = '3.0.3';
    public const VERSION_DEFAULT = self::VERSION_3_1;


    /**
     * @var \Liteapi\Openapi\Generator\Processor\Base\GeneratorProcessor[]
     */
    protected array $preProcessors;

    /**
     * @var GeneratorProcessor[]
     */
    protected array $postProcessors;

    protected string $version = self::VERSION_DEFAULT;

    public function generate(array $config): OpenApi
    {
        $openApi = OpenApi::load($config);
        $openApi->openapi = $this->version;
        $openApi->preValidate($this->preProcessors);
        $openApi->validate();
        $openApi->postValidate($this->postProcessors);
        return $openApi;
    }

    public function addPreProcessors(GeneratorProcessor $processor): void
    {
        $this->preProcessors[] = $processor;
    }

    public function addPostProcessors(GeneratorProcessor $processor): void
    {
        $this->postProcessors[] = $processor;
    }

    /**
     * @param GeneratorProcessor[] $preProcessors
     */
    public function setPreProcessors(array $preProcessors): void
    {
        $this->preProcessors = $preProcessors;
    }

    /**
     * @param GeneratorProcessor[] $postProcessors
     * @return void
     */
    public function setPostProcessors(array $postProcessors): void
    {
        $this->postProcessors = $postProcessors;
    }

    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

}