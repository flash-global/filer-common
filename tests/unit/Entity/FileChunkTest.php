<?php

namespace Tests\Fei\Service\Filer\Entity;

use Codeception\Test\Unit;
use Fei\Service\Filer\Entity\File;
use Fei\Service\Filer\Entity\FileChunk;

/**
 * Class FileTest
 *
 * @package Tests\Fei\Service\Filer\Entity
 */
class FileChunkTest extends Unit
{
    public function testAccessors()
    {
        $this->testOneAccessors('uuid', 'fake-uuid');
        $this->testOneAccessors('totalChunkNumber', 2);
        $this->testOneAccessors('chunkPosition', 1);
        $this->testOneAccessors('octets', 7861);
        $this->testOneAccessors('md5', md5('fake-string'));
        $this->testOneAccessors('chunk', 'fake-blob');
        $this->testOneAccessors('file', '{"id":65}');
        $this->testOneAccessors('ttl', new \Datetime());
        $this->testOneAccessors('revision', 2);
        $this->testOneAccessors('secret', 'fake-secret');
    }

    protected function testOneAccessors($name, $expected)
    {
        $setter = 'set' . ucfirst($name);
        $getter = 'get' . ucfirst($name);
        $auditEventTest = new FileChunk();
        $auditEventTest->$setter($expected);
        $this->assertEquals($auditEventTest->$getter(), $expected);
        $this->assertAttributeEquals($auditEventTest->$getter(), $name, $auditEventTest);
    }
}
