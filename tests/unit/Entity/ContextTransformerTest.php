<?php

namespace Tests\Fei\Service\Filer\Entity;

use Codeception\Test\Unit;
use Fei\Service\Filer\Entity\Context;
use Fei\Service\Filer\Entity\ContextTransformer;

class ContextTransformerTest extends Unit
{
    public function testTransform()
    {
        $transformer = new ContextTransformer();

        $this->assertEquals(
            ['id' => 0, 'key' => 'a key', 'value' => 'a value'],
            $transformer->transform(new Context(['key' => 'a key', 'value' => 'a value']))
        );
    }
}
