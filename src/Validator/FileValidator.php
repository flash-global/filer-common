<?php

namespace Fei\Service\Filer\Validator;

use Doctrine\Common\Collections\ArrayCollection;
use Fei\Entity\EntityInterface;
use Fei\Entity\Validator\AbstractValidator;
use Fei\Entity\Validator\Exception;
use Fei\Service\Filer\Entity\File;

class FileValidator extends AbstractValidator
{
    const UUID_PATTERN =
        '^[0-9A-Za-z]{1,4}:[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$';

    /**
     * {@inheritdoc}
     */
    public function validate(EntityInterface $entity)
    {
        if (!$entity instanceof File) {
            throw new Exception(sprintf('The entity to validate must be an instance of %s', File::class));
        }

        $this->validateUuid($entity->getUuid());
        $this->validateFilename($entity->getFilename());
        $this->validateRevision($entity->getRevision());
        $this->validateCategory($entity->getCategory());
        $this->validateCreatedAt($entity->getCreatedAt());
        $this->validateContentType($entity->getContentType());
        $this->validateData($entity->getData());
        $this->validateContext($entity->getContexts());

        return empty($this->getErrors());
    }

    /**
     * Validate uuid
     *
     * @param mixed $uuid
     *
     * @return bool
     */
    public function validateUuid($uuid)
    {
        if ($uuid === null) {
            return true;
        }

        if (strlen($uuid) == 0) {
            $this->addError('uuid', 'The UUID cannot be an empty string');

            return false;
        }

        if (!preg_match('/' . self::UUID_PATTERN . '/', $uuid)) {
            $this->addError('uuid', 'The UUID `' . $uuid  . '` is not a valid UUID');

            return false;
        }

        return true;
    }

    /**
     * Validate filename
     *
     * @param mixed $filename
     *
     * @return bool
     */
    public function validateFilename($filename)
    {
        if (strlen($filename) === 0) {
            $this->addError('filename', 'The filename cannot be an empty string');

            return false;
        }

        return true;
    }

    /**
     * Validate revision
     *
     * @param mixed $revision
     *
     * @return bool
     */
    public function validateRevision($revision)
    {
        if (empty($revision)) {
            $this->addError('revision', 'The revision cannot be empty');

            return false;
        }

        if (!is_numeric($revision)) {
            $this->addError('revision', 'The revision must be numeric');

            return false;
        }

        return true;
    }

    /**
     * Validate createdAt
     *
     * @param mixed $createdAt
     *
     * @return bool
     */
    public function validateCreatedAt($createdAt)
    {
        if (empty($createdAt)) {
            $this->addError('createdAt', 'Creation date and time cannot be empty');
            return false;
        }

        if (!$createdAt instanceof \DateTime) {
            $this->addError('createdAt', 'The creation date has to be and instance of \DateTime');
            return false;
        }

        return true;
    }

    /**
     * Validate type
     *
     * @param mixed $type
     *
     * @return bool
     */
    public function validateCategory($type)
    {
        if (empty($type)) {
            $this->addError('category', 'The category cannot be empty');

            return false;
        }

        if (!is_numeric($type)) {
            $this->addError('category', 'The category must be numeric');

            return false;
        }

        return true;
    }

    /**
     * Validate Content-Type
     *
     * @param mixed $contentType
     *
     * @return bool
     */
    public function validateContentType($contentType)
    {
        if (strlen($contentType) == 0) {
            $this->addError('contentType', 'Content-Type cannot be empty');

            return false;
        }

        if (mb_strlen($contentType, 'UTF-8') > 255) {
            $this->addError('contentType', 'The Content-Type length has to be less or equal to 255');
            return false;
        }

        return true;
    }

    /**
     * Validate data
     *
     * @param mixed $data
     *
     * @return bool
     */
    public function validateData($data)
    {
        if (strlen($data) == 0) {
            $this->addError('data', 'Data cannot be empty');

            return false;
        }

        return true;
    }

    /**
     * Validate contexts
     *
     * @param mixed $context
     *
     * @return bool
     */
    public function validateContext($context)
    {
        if (!$context instanceof ArrayCollection) {
            $this->addError(
                'contexts',
                'Context has to be and instance of \Doctrine\Common\Collections\ArrayCollection'
            );
            return false;
        }

        if (!$context->isEmpty()) {
            $validator = new ContextValidator();
            foreach ($context as $value) {
                $validator->validate($value);
            }

            if (!empty($validator->getErrors())) {
                $this->addError('contexts', $validator->getErrorsAsString());
                return false;
            }
        }

        return true;
    }
}
