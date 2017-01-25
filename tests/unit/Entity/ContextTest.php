<?php

namespace Tests\Fei\Service\Filer\Entity;

use Codeception\Test\Unit;
use Fei\Service\Filer\Entity\Context;
use Fei\Service\Filer\Entity\File;

class ContextTest extends Unit
{
    public function testId()
    {
        $context = new Context();
        $context->setId(1);

        $this->assertEquals(1, $context->getId());
        $this->assertAttributeEquals($context->getId(), 'id', $context);
    }

    public function testKey()
    {
        $context = new Context();
        $context->setKey(1);

        $this->assertEquals(1, $context->getKey());
        $this->assertAttributeEquals($context->getKey(), 'key', $context);
    }

    public function testValue()
    {
        $context = new Context();
        $context->setValue(1);

        $this->assertEquals(1, $context->getValue());
        $this->assertAttributeEquals($context->getValue(), 'value', $context);
    }

    public function testFile()
    {
        $expected = new File();
        $context = new Context();
        $context->setFile($expected);

        $this->assertEquals($expected, $context->getFile());
        $this->assertAttributeEquals($context->getFile(), 'file', $context);
    }
}
