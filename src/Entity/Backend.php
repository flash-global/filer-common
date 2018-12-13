<?php

namespace Fei\Service\Filer\Entity;

use Fei\Entity\AbstractEntity;

/**
 * Class Backend
 *
 * @Entity
 * @Table(
 *     name="backend",
 * )
 *
 * @package Fei\Service\Filer\Entity
 */
class Backend extends AbstractEntity
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
    protected $name;

    /**
     * @var string
     *
     * @Column(type="string", length=255)
     */
    protected $settings;

    /**
     * @var string
     *
     * @Column(type="string", length=32)
     */
    protected $status;

    /**
     * @var int
     *
     * @Column(type="string", length=32)
     */
    protected $type;

    /**
     * {@inheritdoc}
     */
    public function __construct($data = null)
    {
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
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Settings
     *
     * @return string
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Set Settings
     *
     * @param string $settings
     *
     * @return $this
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * Get Type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set Name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get Status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set Status
     *
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

}
