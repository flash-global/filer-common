<?php

namespace Fei\Service\Filer\Validator;

use Fei\Entity\EntityInterface;
use Fei\Entity\Validator\AbstractValidator;
use Fei\Entity\Validator\Exception;
use Fei\Service\Filer\Entity\FileChunk;

class FileChunkValidator extends AbstractValidator
{
    const UUID_PATTERN =
        '^[0-9A-Za-z]{4}:[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$';

    /**
     * {@inheritdoc}
     */
    public function validate(EntityInterface $entity)
    {
        if (!$entity instanceof FileChunk) {
            throw new Exception(sprintf('The entity to validate must be an instance of %s', FileChunk::class));
        }

        $this->validateUuid($entity->getUuid());
        $this->validateTotalChunkNumber($entity->getTotalChunkNumber());
        $this->validateChunkPosition($entity->getChunkPosition());
        $this->validateOctets($entity->getOctets());
        $this->validateMd5($entity->getMd5());
        $this->validateChunk($entity->getChunk());
        $this->validateTtl($entity->getTtl());
        $this->validateSecret($entity->getSecret());
        $this->validateRevision($entity->getRevision());

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
     * Validate total chunk number
     *
     * @param mixed $total
     *
     * @return bool
     */
    public function validateTotalChunkNumber($total)
    {
        if (!is_numeric($total)) {
            $this->addError('totalChunkNumber', 'The `totalChunkNumber` has to be an integer');

            return false;
        }

        return true;
    }

    /**
     * Validate chunk position
     *
     * @param mixed $position
     *
     * @return bool
     */
    public function validateChunkPosition($position)
    {
        if (!is_numeric($position)) {
            $this->addError('chunkPosition', 'The `chunkPosition` has to be an integer');

            return false;
        }

        return true;
    }

    /**
     * Validate chunk octets
     *
     * @param mixed $octets
     *
     * @return bool
     */
    public function validateOctets($octets)
    {
        if (!is_numeric($octets)) {
            $this->addError('octets', 'The `octets` has to be an integer');

            return false;
        }

        return true;
    }

    /**
     * Validate md5
     *
     * @param mixed $md5
     *
     * @return bool
     */
    public function validateMd5($md5)
    {
        if (!is_string($md5) || empty($md5)) {
            $this->addError('md5', 'The `md5` has to be an valid string');

            return false;
        }

        return true;
    }

    /**
     * Validate chunk
     *
     * @param mixed $chunk
     *
     * @return bool
     */
    public function validateChunk($chunk)
    {
        if (!is_string($chunk) || empty($chunk)) {
            $this->addError('chunk', 'The `chunk` has to be an valid string');

            return false;
        }

        return true;
    }

    /**
     * Validate ttl
     *
     * @param mixed $ttl
     *
     * @return bool
     */
    public function validateTtl($ttl)
    {
        if (!$ttl instanceof \DateTime) {
            $this->addError('ttl', 'The `ttl` has to be an instance of ' . \DateTime::class);

            return false;
        }

        return true;
    }

    /**
     * Validate secret
     *
     * @param mixed $secret
     *
     * @return bool
     */
    public function validateSecret($secret)
    {
        if (empty($secret)) {
            $this->addError('secret', 'The `secret` has to be an non empty string');

            return false;
        }

        return true;
    }

    /**
     * Validate the revision
     *
     * @param mixed $revision
     *
     * @return bool
     */
    public function validateRevision($revision)
    {
        if (!is_numeric($revision) && !is_null($revision)) {
            $this->addError('revision', 'The `revision` has to be a valid integer');

            return false;
        }

        return true;
    }
}
