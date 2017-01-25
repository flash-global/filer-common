<?php

namespace Tests\Fei\Service\Filer\Entity;

use Codeception\Test\Unit;
use Codeception\Util\Stub;
use Doctrine\Common\Collections\ArrayCollection;
use Fei\Service\Filer\Entity\Context;
use Fei\Service\Filer\Entity\File;

/**
 * Class FileTest
 *
 * @package Tests\Fei\Service\Filer\Entity
 */
class FileTest extends Unit
{
    public function testIdAccessors()
    {
        $file = new File();
        $file->setId(1);

        $this->assertEquals(1, $file->getId());
        $this->assertAttributeEquals($file->getId(), 'id', $file);
    }

    public function testUuidAccessors()
    {
        $file = new File();
        $uuid = 'f81d4fae-7dec-11d0-a765-00a0c91e6bf6';
        $file->setUuid($uuid);

        $this->assertEquals($uuid, $file->getUuid());
        $this->assertAttributeEquals($file->getUuid(), 'uuid', $file);
    }

    public function testCreatedAteAccessors()
    {
        $file = new File();
        $file->setCreatedAt('2016-12-19 00:00:00');

        $this->assertEquals(new \DateTime('2016-12-19 00:00:00'), $file->getCreatedAt());
        $this->assertAttributeEquals($file->getCreatedAt(), 'createdAt', $file);
    }

    public function testRevisionAccessors()
    {
        $file = new File();
        $file->setRevision(1);

        $this->assertEquals(1, $file->getRevision());
        $this->assertAttributeEquals($file->getRevision(), 'revision', $file);
    }

    public function testCategoryAccessors()
    {
        $file = new File();
        $file->setCategory(2);

        $this->assertEquals(2, $file->getCategory());
        $this->assertAttributeEquals($file->getCategory(), 'category', $file);
    }

    public function testContentTypeAccessors()
    {
        $file = new File();
        $file->setContentType('application/pdf');

        $this->assertEquals('application/pdf', $file->getContentType());
        $this->assertAttributeEquals($file->getContentType(), 'contentType', $file);
    }

    public function testContentTypeAccessorsWithSplFileObject()
    {
        $file = new File();

        $file->setFile(new \SplFileObject(__DIR__ . '/../../_data/dump.sql'));

        $this->assertEquals('text/plain', $file->getContentType());

        $file->setContentType('test');

        $this->assertEquals('test', $file->getContentType());
    }

    public function testDataAccessors()
    {
        $file = new File();
        $file->setData('data');

        $this->assertEquals('data', $file->getData());
        $this->assertAttributeEquals($file->getData(), 'data', $file);
    }

    public function testDataAccessorsWithSplFileObject()
    {
        $file = new File();

        $file->setFile(new \SplFileObject(__DIR__ . '/../../_data/dump.sql'));

        $this->assertEquals(file_get_contents(__DIR__ . '/../../_data/dump.sql'), $file->getData());

        $file->setData('test');

        $this->assertEquals('test', $file->getData());
    }

    public function testFileAccessors()
    {
        $file = new File();
        $file->setFile(new \SplFileObject(__DIR__ . '/../../_data/dump.sql'));

        $this->assertEquals(new \SplFileObject(__DIR__ . '/../../_data/dump.sql'), $file->getFile());
        $this->assertAttributeEquals($file->getFile(), 'file', $file);
    }

    public function testContextAccessors()
    {
        $file = new File();
        $file->setContexts(new Context());

        $context = new Context();
        $context->setFile($file);

        $this->assertEquals(new ArrayCollection([$context]), $file->getContexts());
        $this->assertAttributeEquals($file->getContexts(), 'contexts', $file);
    }

    public function testAddingContext()
    {
        $collection = $this->getMockBuilder(ArrayCollection::class)->setMethods(['add'])->getMock();
        $collection->expects($this->once())->method('add');

        $file = Stub::make(File::class, [
            'getContexts' => $collection
        ]);

        $context = $this->getMockBuilder(Context::class)->setMethods(['setFile'])->getMock();
        $context->expects($this->once())->method('setfile');

        $return = $file->addContext($context);

        $this->assertInstanceOf(File::class, $return);
    }

    public function testHydrate()
    {
        $uuid = 'f81d4fae-7dec-11d0-a765-00a0c91e6bf6';

        $now = new \DateTime();

        $file = new File([
            'id' => 1,
            'uuid' => $uuid,
            'content_type' => 'application/pdf',
            'category' => 2,
            'file' => null,
            'created_at' => $now->format(\DateTime::ISO8601),
            'data' => base64_encode('some data'),
            'revision' => 2
        ]);

        $expectedFile = (new File())
            ->setId(1)
            ->setUuid($uuid)
            ->setCreatedAt($now->format(\DateTime::ISO8601))
            ->setContentType('application/pdf')
            ->setCategory(2)
            ->setRevision(2)
            ->setData('some data');

        $this->assertEquals($expectedFile, $file);
    }

    public function testToArrayWithSplFileObject()
    {
        $now = new \DateTime();

        $file = new File(['created_at' => $now]);

        $file->setFile(new \SplFileObject(__DIR__ . '/../../_data/dump.sql'));

        $this->assertEquals(
            [
                'id' => null,
                'uuid' => null,
                'created_at' => $now->format(\DateTime::RFC3339),
                'category' => null,
                'filename' => 'dump.sql',
                'revision' => 1,
                'content_type' => 'text/plain',
                'data' => base64_encode(file_get_contents(__DIR__ . '/../../_data/dump.sql')),
                'contexts' => []
            ],
            $file->toArray()
        );
    }
}
