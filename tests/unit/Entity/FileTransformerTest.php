<?php

namespace Tests\Fei\Service\Filer\Entity;

use Codeception\Test\Unit;
use Doctrine\Common\Collections\ArrayCollection;
use Fei\Service\Filer\Entity\Context;
use Fei\Service\Filer\Entity\File;
use Fei\Service\Filer\Entity\FileTransformer;

/**
 * Class MessageTransformerTest
 *
 * @package Tests\Fei\Service\Chat\Entity
 */
class FileTransformerTest extends Unit
{
    public function testTransform()
    {
        $context = new Context(['test' => 'test']);

        $now = new \DateTime();

        $file = (new File())
            ->setId(1)
            ->setUuid('test')
            ->setCreatedAt($now)
            ->setRevision(2)
            ->setCategory(3)
            ->setFile(new \SplFileObject(__DIR__ . '/../../_data/dump.sql'))
            ->setContexts(new Context(['key' => 'a key', 'value' => 'a value']));

        $context->setFile($file);

        $this->assertEquals(
            [
                'id' => 1,
                'uuid' => 'test',
                'filename' => 'dump.sql',
                'created_at' => $now->format(\DateTime::ISO8601),
                'revision' => 2,
                'category' => 3,
                'content_type' => 'text/plain',
                'contexts' => [
                    'a key' => 'a value'
                ]
            ],
            (new FileTransformer())->transform($file)
        );
    }
}
