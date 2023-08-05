<?php

namespace Liteapi\Openapi\Test\Element;

use Liteapi\Openapi\Exception\NodeValidationException;
use PHPUnit\Framework\TestCase;

class OpenApiTest extends TestCase
{

    public function test__construct(): void
    {
        $element = new OpenApi('1.0.0');
        $this->expectNotToPerformAssertions();
    }

    public function testLoad(): void
    {
        $element = OpenApi::load(['version' => '1.0.1']);
        $this->assertInstanceOf(OpenApi::class, $element);
    }

    public function testValidate(): void
    {
        $element = new OpenApi('1.0');
        $element->validate();
        $this->expectNotToPerformAssertions();
    }

    public function testWrongValueValidate(): void
    {
        $element = new OpenApi('abc.0.0');
        $this->expectException(NodeValidationException::class);
        $element->validate();
    }

    public function testGetValue(): void
    {
        $element = new OpenApi('1.0.0');
        $element->validate();
        $value = $element->getValue();
        $this->assertEquals('1.0.0', $value);
    }

}
