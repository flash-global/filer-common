<?php

namespace Fei\Service\Filer\Entity;

use Fei\Entity\AbstractEntity;

/**
 * Class Context
 *
 * @package Fei\Service\Filer\Entity
 *
 * @Entity
 * @Table(name="contexts")
 */
class Context extends AbstractEntity
{
    /**
     * @var int
     *
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @var File
     *
     * @ManyToOne(targetEntity="File", inversedBy="contexts")
     * @JoinColumn(name="file_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $file;

    /**
     * @var string
     *
     * @Column(type="string", name="`key`")
     */
    protected $key;

    /**
     * @var string
     *
     * @Column(type="text", name="`value`")
     */
    protected $value;

    /**
     * Get Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Id
     *
     * @param mixed $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get File
     *
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set File
     *
     * @param File $file
     *
     * @return $this
     */
    public function setFile(File $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set key
     *
     * @param string $key
     *
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get value
     *
     * @param string $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
