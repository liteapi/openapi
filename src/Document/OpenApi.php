<?php

namespace Liteapi\Openapi\Document;

use Composer\Autoload\ClassLoader;
use Composer\InstalledVersions;
use Liteapi\Openapi\Element\Attribute\ArrayList;
use Liteapi\Openapi\Element\Attribute\Map;
use Liteapi\Openapi\Element\Attribute\Omit;
use Liteapi\Openapi\Element\Attribute\Required;
use Liteapi\Openapi\Element\Attribute\Uri;
use Liteapi\Openapi\Element\Attribute\Validation;
use Liteapi\Openapi\Element\Base\ExtendedElement;
use Liteapi\Openapi\Element\Components;
use Liteapi\Openapi\Element\ExternalDocumentation;
use Liteapi\Openapi\Element\Info;
use Liteapi\Openapi\Element\JsonSchemaDialect;
use Liteapi\Openapi\Element\Path;
use Liteapi\Openapi\Element\Paths;
use Liteapi\Openapi\Element\Reference;
use Liteapi\Openapi\Element\SecurityRequirement;
use Liteapi\Openapi\Element\Server;
use Liteapi\Openapi\Element\Tag;
use Liteapi\Openapi\Element\Type\ValidationType;
use Liteapi\Openapi\Generator\Processor\Base\GeneratorProcessor;

class OpenApi extends ExtendedElement
{

    #[Required]
    #[Validation(ValidationType::Regex, '/^\d\.\d(\.\d)?$/', 'Must be in format X.X.X')]
    public ?string $openapi = null;
    #[Required]
    public ?Info $info = null;
    #[Uri]
    public ?string $jsonSchemaDialect = null;
    #[ArrayList(Server::class)]
    public ?array $servers = null;
    public ?Paths $paths = null;
    #[Map('string', [Path::class, Reference::class])]
    public ?array $webhooks = null;
    public ?Components $components = null;
    #[ArrayList(SecurityRequirement::class)]
    public ?array $security = null;
    #[ArrayList(Tag::class)]
    public ?array $tags = null;
    public ?ExternalDocumentation $externalDocs = null;

    /* Omitted properties */
    #[Omit]
    protected ?array $generatedValue = null;

    protected function loadDefault(): void
    {
        if (empty($this->servers)) {
            $this->servers = [new Server('/')];
        }
    }

    /**
     * @param GeneratorProcessor[] $processors
     * @return void
     */
    public function preValidate(array $processors): void
    {
        foreach ($processors as $processor) {
            $processor->process($this);
        }
    }

    /**
     * @param \Liteapi\Openapi\Generator\Processor\Base\GeneratorProcessor[] $processors
     * @return void
     */
    public function postValidate(array $processors): void
    {
        foreach ($processors as $processor) {
            $processor->process($this);
        }
    }

    public function toYaml(bool $regenerate = false): string
    {
        if (InstalledVersions::isInstalled('symfony/yaml')) {
            throw new \Exception('Package symfony/yaml is not installed');
        }
        if ($regenerate === true || $this->generatedValue === null) {
            $this->generatedValue = $this->getValue();
        }
        $yamlClass = 'Symfony\Component\Yaml\Yaml';
        return $yamlClass::dump($this->generatedValue);
    }

    public function toJson(bool $regenerate = false): string
    {
        if ($regenerate === true || $this->generatedValue === null) {
            $this->generatedValue = $this->getValue();
        }
        $json = json_encode($this->generatedValue);
        if ($json === false) {
            throw new \Exception('Error while creating json from OpenApi document');
        }
        return $json;
    }

}