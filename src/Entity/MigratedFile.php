<?php

namespace Fei\Service\Filer\Entity;

use Fei\Entity\AbstractEntity;

/**
 * Class MigratedFile
 *
 * @package Fei\Service\Filer\Entity
 *
 * @Entity
 * @Table(name="migrated_files")
 */
class MigratedFile extends AbstractEntity
{
    /**
     * @var File
     *
     * @OneToOne(targetEntity="File", mappedBy="migratedFile")
     * @JoinColumn(name="file_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $file;

    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }

    /**
     * @param File $file
     * @return $this
     */
    public function setFile(File $file): self
    {
        $this->file = $file;
        return $this;
    }
}
