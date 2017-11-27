<?php
namespace Fei\Service\Filer\Entity;

use Fei\Entity\AbstractEntity;

/**
 * Class FileChunk
 *
 * @package Fei\Service\Filer\Entity
 */
class FileChunk extends AbstractEntity
{
    /** @var string */
    protected $uuid;

    /**
     * Represent the total number of chunks
     *
     * @var int
     */
    protected $totalChunkNumber;

    /**
     * Represent the chunk position
     *
     * @var int
     */
    protected $chunkPosition;

    /**
     * Represent the size of the chunk
     *
     * @var int
     */
    protected $octets;

    /**
     * Represent the md5 of the chunk's blob
     *
     * @var string
     */
    protected $md5;

    /**
     * Represent the blob of the chunk
     *
     * @var string
     */
    protected $blob;

    /**
     * Contains the file serialized to further usage
     *
     * @var string
     */
    protected $file;

    /**
     * Represent the time to live
     *
     * @var \Datetime
     */
    protected $ttl;

    /**
     * Get Uuid
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set Uuid
     *
     * @param string $uuid
     *
     * @return FileChunk
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get TotalChunkNumber
     *
     * @return int
     */
    public function getTotalChunkNumber()
    {
        return $this->totalChunkNumber;
    }

    /**
     * Set TotalChunkNumber
     *
     * @param int $totalChunkNumber
     *
     * @return FileChunk
     */
    public function setTotalChunkNumber($totalChunkNumber)
    {
        $this->totalChunkNumber = $totalChunkNumber;

        return $this;
    }

    /**
     * Get ChunkPosition
     *
     * @return int
     */
    public function getChunkPosition()
    {
        return $this->chunkPosition;
    }

    /**
     * Set ChunkPosition
     *
     * @param int $chunkPosition
     *
     * @return FileChunk
     */
    public function setChunkPosition($chunkPosition)
    {
        $this->chunkPosition = $chunkPosition;

        return $this;
    }

    /**
     * Get Octets
     *
     * @return int
     */
    public function getOctets()
    {
        return $this->octets;
    }

    /**
     * Set Octets
     *
     * @param int $octets
     *
     * @return FileChunk
     */
    public function setOctets($octets)
    {
        $this->octets = $octets;

        return $this;
    }

    /**
     * Get Md5
     *
     * @return string
     */
    public function getMd5()
    {
        return $this->md5;
    }

    /**
     * Set Md5
     *
     * @param string $md5
     *
     * @return FileChunk
     */
    public function setMd5($md5)
    {
        $this->md5 = $md5;

        return $this;
    }

    /**
     * Get Blob
     *
     * @return string
     */
    public function getBlob()
    {
        return $this->blob;
    }

    /**
     * Set Blob
     *
     * @param string $blob
     *
     * @return FileChunk
     */
    public function setBlob($blob)
    {
        $this->blob = $blob;

        return $this;
    }

    /**
     * Get File
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set File
     *
     * @param string $file
     *
     * @return FileChunk
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get Ttl
     *
     * @return \Datetime
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * Set Ttl
     *
     * @param \Datetime $ttl
     *
     * @return FileChunk
     */
    public function setTtl(\Datetime $ttl)
    {
        $this->ttl = $ttl;

        return $this;
    }
}
