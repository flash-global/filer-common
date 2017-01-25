<?php

namespace Tests\Fei\Service\Filer\Validator;

use Codeception\Test\Unit;
use Codeception\Util\Stub;
use Doctrine\Common\Collections\ArrayCollection;
use Fei\Entity\AbstractEntity;
use Fei\Entity\Validator\Exception;
use Fei\Service\Filer\Entity\Context;
use Fei\Service\Filer\Entity\File;
use Fei\Service\Filer\Validator\FileValidator;

/**
 * Class FileValidatorTest
 *
 * @package Tests\Fei\Service\Filer\Validator
 */
class FileValidatorTest extends Unit
{
    public function testValidate()
    {
        $validator = new FileValidator();

        $file = (new File())
            ->setId(1)
            ->setUuid('test:00000000-0000-0000-0000-000000000000')
            ->setRevision(2)
            ->setCategory(3)
            ->setFile(new \SplFileObject(__DIR__ . '/../../_data/dump.sql'));

        $this->assertTrue($validator->validate($file));
        $this->assertEmpty($validator->getErrors());

        $validator = new FileValidator();

        $file = (new File())
            ->setId(1)
            ->setRevision(2)
            ->setCategory(3)
            ->setFile(new \SplFileObject(__DIR__ . '/../../_data/dump.sql'));

        $this->assertTrue($validator->validate($file));
        $this->assertEmpty($validator->getErrors());
    }

    public function testValidateNoFileEntity()
    {
        $validator = new FileValidator();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'The entity to validate must be an instance of ' . File::class
        );

        $validator->validate(new class extends AbstractEntity {});
    }

    public function testValidateUuid()
    {
        $validator = new FileValidator();

        $this->assertFalse($validator->validateUuid(''));
        $this->assertEquals('The UUID cannot be an empty string', $validator->getErrors()['uuid'][0]);

        $this->assertFalse($validator->validateUuid('test'));
        $this->assertEquals('The UUID `test` is not a valid UUID', $validator->getErrors()['uuid'][1]);

        $this->assertFalse($validator->validateUuid(0));
        $this->assertEquals('The UUID `0` is not a valid UUID', $validator->getErrors()['uuid'][2]);

        $this->assertTrue($validator->validateUuid(null));

        $this->assertTrue($validator->validateUuid('test:00000000-0000-0000-0000-000000000000'));
        $this->assertTrue($validator->validateUuid('db1:00000000-0000-0000-0000-000000000000'));
        $this->assertFalse($validator->validateUuid(':00000000-0000-0000-0000-000000000000'));
        $this->assertFalse($validator->validateUuid('123456:00000000-0000-0000-0000-000000000000'));
        $this->assertTrue($validator->validateUuid('a:00000000-0000-0000-0000-000000000000'));
        $this->assertTrue($validator->validateUuid('1:00000000-0000-0000-0000-000000000000'));
    }

    public function testValidateCreatedAt()
    {
        $validator = new FileValidator();

        $this->assertFalse($validator->validateCreatedAt(''));
        $this->assertEquals('Creation date and time cannot be empty', $validator->getErrors()['createdAt'][0]);

        $validator = new FileValidator();

        $this->assertFalse($validator->validateCreatedAt('test'));
        $this->assertEquals(
            'The creation date has to be and instance of \DateTime',
            $validator->getErrors()['createdAt'][0]
        );

        $validator = new FileValidator();

        $this->assertTrue($validator->validateCreatedAt(new \DateTime()));
        $this->assertEmpty($validator->getErrors());
    }

    public function testValidateCategory()
    {
        $validator = new FileValidator();

        $this->assertFalse($validator->validateCategory(null));
        $this->assertEquals('The category cannot be empty', $validator->getErrors()['category'][0]);
        $this->assertFalse($validator->validateCategory(''));
        $this->assertEquals('The category cannot be empty', $validator->getErrors()['category'][1]);
        $this->assertFalse($validator->validateCategory(0));
        $this->assertEquals('The category cannot be empty', $validator->getErrors()['category'][2]);

        $this->assertFalse($validator->validateCategory('test'));
        $this->assertEquals('The category must be numeric', $validator->getErrors()['category'][3]);

        $this->assertTrue($validator->validateCategory(1));
    }

    public function testValidateFilename()
    {
        $fileValidator = new FileValidator();

        $whenNull = $fileValidator->validateFilename(null);
        $whenEmpty = $fileValidator->validateFilename('');
        $whenValid = $fileValidator->validateFilename('fake-path.pdf');

        $this->assertFalse($whenNull);
        $this->assertFalse($whenEmpty);
        $this->assertTrue($whenValid);
    }

    public function testValidateRevision()
    {
        $validator = new FileValidator();

        $this->assertFalse($validator->validateRevision(null));
        $this->assertEquals('The revision cannot be empty', $validator->getErrors()['revision'][0]);
        $this->assertFalse($validator->validateRevision(''));
        $this->assertEquals('The revision cannot be empty', $validator->getErrors()['revision'][1]);
        $this->assertFalse($validator->validateRevision(0));
        $this->assertEquals('The revision cannot be empty', $validator->getErrors()['revision'][2]);

        $this->assertFalse($validator->validateRevision('test'));
        $this->assertEquals('The revision must be numeric', $validator->getErrors()['revision'][3]);

        $this->assertTrue($validator->validateRevision(1));
    }

    public function testValidateContentType()
    {
        $validator = new FileValidator();

        $this->assertFalse($validator->validateContentType(''));
        $this->assertEquals('Content-Type cannot be empty', $validator->getErrors()['contentType'][0]);

        $this->assertFalse($validator->validateContentType(str_repeat('☃', 256)));
        $this->assertEquals(
            'The Content-Type length has to be less or equal to 255',
            $validator->getErrors()['contentType'][1]
        );

        $this->assertTrue($validator->validateContentType('test'));
    }

    public function testValidateData()
    {
        $validator = new FileValidator();

        $this->assertFalse($validator->validateData(''));
        $this->assertEquals('Data cannot be empty', $validator->getErrors()['data'][0]);

        $this->assertTrue($validator->validateData('test'));
    }

    public function testValidateContext()
    {
        $fileValidator = new FileValidator();

        $whenIsNotAnArrayCollection = $fileValidator->validateContext(['key' => 'val']);
        $whenIsEmpty = $fileValidator->validateContext(new ArrayCollection());

        $contexts = new ArrayCollection();
        $contexts->add((new Context())
            ->setKey('key')
            ->setValue('val')
        );
        $whenIsNotEmptyAndChildAreValid = $fileValidator->validateContext($contexts);

        $contexts = new ArrayCollection();
        $contexts->add(new Context());
        $whenIsNotEmptyButChildAreNotValid = $fileValidator->validateContext($contexts);

        $this->assertFalse($whenIsNotAnArrayCollection);
        $this->assertFalse($whenIsNotEmptyButChildAreNotValid);
        $this->assertTrue($whenIsNotEmptyAndChildAreValid);
        $this->assertTrue($whenIsEmpty);


        $contexts = new ArrayCollection();
        $contexts->add('value');

        $this->expectException(\TypeError::class);
        $fileValidator->validateContext($contexts);

    }
}
