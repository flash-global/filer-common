<?php

namespace Fei\Service\Filer\Entity;

use Fei\Entity\AbstractEntity;

/**
 * Class File
 *
 * @Entity
 * @Table(
 *     name="categories",
 * )
 *
 * @package Fei\Service\Filer\Entity
 */
class Category extends AbstractEntity
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
     * @var string
     *
     * @Column(type="string", length=32)
     */
    protected $label;

    /**
     * @var int
     *
     * @Column(type="integer")
     */
    protected $backend = 1;

    /**
     * @var int
     *
     * @Column(type="integer")
     */
    protected $status;

    /**
     * @var \DateTime
     *
     * @Column(type="datetime")
     */
    protected $createdAt;

    /**
     * {@inheritdoc}
     */
    public function __construct($data = null)
    {
        $this->setCreatedAt(new \DateTime());
        parent::__construct($data);
    }

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
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get Status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set Status
     *
     * @param int $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get Uuid
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set Uuid
     *
     * @param string $label
     *
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get Backend
     *
     * @return int
     */
    public function getBackend()
    {
        return $this->backend;
    }

    /**
     * Set Backend
     *
     * @param int $backend
     *
     * @return $this
     */
    public function setBackend($backend)
    {
        $this->backend = $backend;

        return $this;
    }

    /**
     * Get CreatedAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set CreatedAt
     *
     * @param \DateTime|string $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        if (!$createdAt instanceof \DateTime) {
            $createdAt = new \DateTime($createdAt);
        }

        $this->createdAt = $createdAt;

        return $this;
    }
}
