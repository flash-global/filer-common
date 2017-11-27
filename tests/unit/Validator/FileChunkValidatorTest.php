<?php

namespace Tests\Fei\Service\Filer\Validator;

use Codeception\Test\Unit;
use Codeception\Util\Stub;
use Doctrine\Common\Collections\ArrayCollection;
use Fei\Entity\AbstractEntity;
use Fei\Entity\Validator\Exception;
use Fei\Service\Filer\Entity\Context;
use Fei\Service\Filer\Entity\File;
use Fei\Service\Filer\Entity\FileChunk;
use Fei\Service\Filer\Validator\FileChunkValidator;
use Fei\Service\Filer\Validator\FileValidator;

/**
 * Class FileValidatorTest
 *
 * @package Tests\Fei\Service\Filer\Validator
 */
class FileChunkValidatorTest extends Unit
{
    public function testValidate()
    {
        $validator = Stub::make(FileChunkValidator::class, [
            'validateUuid' => Stub::once(function () { return true;}),
            'validateTotalChunkNumber' => Stub::once(function () { return true;}),
            'validateChunkPosition' => Stub::once(function () { return true;}),
            'validateOctets' => Stub::once(function () { return true;}),
            'validateMd5' => Stub::once(function () { return true;}),
            'validateBlob' => Stub::once(function () { return true;}),
            'validateTtl' => Stub::once(function () { return true;}),
            'getErrors' => [],
        ]);

        $this->assertTrue($validator->validate(new FileChunk()));
    }

    public function testValidateNoFileChunkEntity()
    {
        $validator = new FileChunkValidator();

        $this->setExpectedException(Exception::class, 'The entity to validate must be an instance of ' . FileChunk::class);

        $validator->validate($this->getMockBuilder(AbstractEntity::class)->getMockForAbstractClass());
    }

    public function testValidateUuid()
    {
        $validator = new FileChunkValidator();

        $this->assertFalse($validator->validateUuid(''));
        $this->assertEquals('The UUID cannot be an empty string', $validator->getErrors()['uuid'][0]);

        $this->assertFalse($validator->validateUuid('test'));
        $this->assertEquals('The UUID `test` is not a valid UUID', $validator->getErrors()['uuid'][1]);

        $this->assertFalse($validator->validateUuid(0));
        $this->assertEquals('The UUID `0` is not a valid UUID', $validator->getErrors()['uuid'][2]);

        $this->assertTrue($validator->validateUuid(null));

        $this->assertTrue($validator->validateUuid('test:00000000-0000-0000-0000-000000000000'));
        $this->assertTrue($validator->validateUuid('bck1:00000000-0000-0000-0000-000000000000'));
        $this->assertFalse($validator->validateUuid('db1:00000000-0000-0000-0000-000000000000'));
        $this->assertFalse($validator->validateUuid(':00000000-0000-0000-0000-000000000000'));
        $this->assertFalse($validator->validateUuid('123456:00000000-0000-0000-0000-000000000000'));
        $this->assertFalse($validator->validateUuid('a:00000000-0000-0000-0000-000000000000'));
        $this->assertFalse($validator->validateUuid('1:00000000-0000-0000-0000-000000000000'));
        $this->assertFalse($validator->validateUuid('00000000-0000-0000-0000-000000000000'));
    }

    public function testValidateTotalChunkNumber()
    {
        $validator = new FileChunkValidator();

        $this->assertFalse($validator->validateTotalChunkNumber(''));
        $this->assertEquals('The `totalChunkNumber` has to be an integer', $validator->getErrors()['totalChunkNumber'][0]);

        $this->assertTrue($validator->validateTotalChunkNumber(2));
    }

    public function testValidateChunkPosition()
    {
        $validator = new FileChunkValidator();

        $this->assertFalse($validator->validateChunkPosition(''));
        $this->assertEquals('The `chunkPosition` has to be an integer', $validator->getErrors()['chunkPosition'][0]);

        $this->assertTrue($validator->validateChunkPosition(2));
    }

    public function testValidateOctets()
    {
        $validator = new FileChunkValidator();

        $this->assertFalse($validator->validateOctets(''));
        $this->assertEquals('The `octets` has to be an integer', $validator->getErrors()['octets'][0]);

        $this->assertTrue($validator->validateOctets(2658));
    }

    public function testValidateMd5()
    {
        $validator = new FileChunkValidator();

        $this->assertFalse($validator->validateMd5(''));
        $this->assertEquals('The `md5` has to be an valid string', $validator->getErrors()['md5'][0]);

        $this->assertTrue($validator->validateMd5(md5('str')));
    }

    public function testValidateBlob()
    {
        $validator = new FileChunkValidator();

        $this->assertFalse($validator->validateBlob(''));
        $this->assertEquals('The `blob` has to be an valid string', $validator->getErrors()['blob'][0]);

        $this->assertTrue($validator->validateBlob('str'));
    }

    public function testValidateTtl()
    {
        $validator = new FileChunkValidator();

        $this->assertFalse($validator->validateTtl(''));
        $this->assertEquals('The `ttl` has to be an instance of ' . \DateTime::class, $validator->getErrors()['ttl'][0]);

        $this->assertTrue($validator->validateTtl(new \DateTime()));
    }
}
