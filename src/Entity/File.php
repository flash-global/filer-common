<?php

namespace Fei\Service\Filer\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Fei\Entity\AbstractEntity;

/**
 * Class File
 *
 * @Entity
 * @Table(
 *     name="files",
 *     uniqueConstraints={ @UniqueConstraint(name="revision_unique", columns={ "uuid", "revision" }) }
 * )
 *
 * @package Fei\Service\Filer\Entity
 */
class File extends AbstractEntity
{
    const CATEGORY_LOGO = 1;
    const CATEGORY_IMG = 2;
    const CATEGORY_INVOICE = 3;
    const CATEGORY_CMR = 4;
    const CATEGORY_MISCELLANEOUS = 5;
    const CATEGORY_SINISTRE = 6;
    const CATEGORY_MAIL = 7;
    const CATEGORY_EDI = 8;
    const CATEGORY_REIMBURSEMENT = 9;
    const CATEGORY_SUPPLIER = 10;
    const CATEGORY_CLIENT = 11;
    const CATEGORY_INVOICE_TEMP = 12;
    const CATEGORY_CREDIT_NOTE = 13;
    const CATEGORY_GLOBAL_INVOICE = 14;
    const CATEGORY_GLOBAL_INVOICE_TEMP = 15;
    const CATEGORY_INVOICE_INTERFACE = 16;
    const CATEGORY_WAYBILLS = 98;

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
     * @Column(type="string", length=41)
     */
    protected $uuid;

    /**
     * @var string
     *
     * @Column(type="string")
     */
    protected $filename;

    /**
     * @var int
     *
     * @Column(type="integer")
     */
    protected $revision = 1;

    /**
     * @var int
     *
     * @Column(type="integer")
     */
    protected $category;

    /**
     * @var \DateTime
     *
     * @Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var string
     *
     * @Column(type="string")
     */
    protected $contentType;

    /**
     * @var string
     *
     * @Column(type="blob")
     */
    protected $data;

    /**
     * @var \SplFileObject
     */
    protected $file;

    /**
     * @var ArrayCollection
     *
     * @OneToMany(targetEntity="Context", mappedBy="file", cascade={"all"}, fetch="EAGER")
     */
    protected $contexts;

    /**
     * @var MigratedFile
     *
     * @OneToOne(targetEntity="File", inversedBy="file", cascade={"SET NULL"}, fetch="EAGER")
     */
    protected $migratedFile;

    /**
     * {@inheritdoc}
     */
    public function __construct($data = null)
    {
        $this->contexts = new ArrayCollection();
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
     * @return $this
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get Filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set Filename
     *
     * @param string $filename
     *
     * @return $this
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get Revision
     *
     * @return int
     */
    public function getRevision()
    {
        return $this->revision;
    }

    /**
     * Set Revision
     *
     * @param int $revision
     *
     * @return $this
     */
    public function setRevision($revision)
    {
        $this->revision = $revision;

        return $this;
    }

    /**
     * Get Category
     *
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set Category
     *
     * @param int $category
     *
     * @return $this
     */
    public function setCategory($category)
    {
        $this->category = $category;

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

    /**
     * Get ContentType
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Set the content type of the file
     *
     * @param string $contentType
     *
     * @return $this
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Get Data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set Data
     *
     * @param string $data
     *
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get File
     *
     * @return \SplFileObject
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set File
     *
     * @param \SplFileObject $file
     *
     * @return $this
     */
    public function setFile(\SplFileObject $file)
    {
        $this->file = $file;

        $data = '';
        while (!$this->getFile()->eof()) {
            $data .= $this->getFile()->fgets();
        }

        $this->setData($data);
        $this->setContentType(finfo_file(finfo_open(FILEINFO_MIME_TYPE), $this->getFile()->getRealPath()));

        if (null === $this->getFilename()) {
            $this->setFilename($file->getFilename());
        }
        return $this;
    }


    /**
     * Get context
     *
     * @return ArrayCollection
     */
    public function getContexts()
    {
        return $this->contexts;
    }

    /**
     * @param $context
     *
     * @return $this
     */
    public function setContexts($context)
    {
        if ($context instanceof Context) {
            $context = array($context);
        }

        if ($context instanceof \ArrayObject || is_array($context) || $context instanceof \Iterator) {
            foreach ($context as $key => $value) {
                if (!$value instanceof Context) {
                    $value = $value instanceof \stdClass ? (array) $value : $value;

                    if (is_int($key)
                        && is_array($value)
                        && array_key_exists('key', $value)
                        && array_key_exists('value', $value)
                    ) {
                        $contextData = array('key' => $value['key'], 'value' => $value['value']);

                        if (isset($value['id'])) {
                            $contextData['id'] = $value['id'];
                        }
                    } else {
                        $contextData = array('key' => $key, 'value' => $value);
                    }

                    $value = new Context($contextData);
                }

                $updatedContext = false;
                foreach ($this->getContexts() as $context) {
                    if ($context->getKey() === $value->getKey()) {
                        $context->setValue($value->getValue());
                        $updatedContext = true;
                        break;
                    }
                }

                if (!$updatedContext) {
                    $this->contexts->add($value);
                    $value->setFile($this);
                }
            }
        }

        return $this;
    }

    /**
     * @param Context $context
     *
     * @return File
     */
    public function addContext(Context $context)
    {
        $context->setFile($this);
        $this->getContexts()->add($context);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hydrate($data)
    {
        if (array_key_exists('file', $data)) {
            unset($data['file']);
        }

        if (array_key_exists('data', $data)) {
            $data['data'] = base64_decode($data['data']);
        }

        parent::hydrate($data);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray($mapped = false)
    {
        $data = parent::toArray($mapped);

        $data['data'] = base64_encode($this->getData());

        unset($data['file']);

        if (!empty($data['contexts'])) {
            $context = array();
            foreach ($data['contexts'] as $key => $value) {
                $context[$key] = $value->toArray();
                unset($context[$key]['file']);
            }
            $data['contexts'] = $context;
        }

        return $data;
    }

    /**
     * @return MigratedFile
     */
    public function getMigratedFile()
    {
        return $this->migratedFile;
    }

    /**
     * @param MigratedFile $migratedFile
     * @return $this
     */
    public function setMigratedFile($migratedFile): self
    {
        $this->migratedFile = $migratedFile;
        return $this;
    }
}
