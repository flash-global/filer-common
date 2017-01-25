<?php

namespace Fei\Service\Filer\Entity;

use League\Fractal\TransformerAbstract;

/**
 * Class FileTransformer
 *
 * @package Fei\Service\Filer\Entity
 */
class FileTransformer extends TransformerAbstract
{
    public function transform(File $file)
    {
        $contextItems = array();

        foreach ($file->getContexts() as $contextItem) {
            $contextItems[$contextItem->getKey()] = $contextItem->getValue();
        }

        return array(
            'id' => (int) $file->getId(),
            'uuid' => $file->getUuid(),
            'filename' => $file->getFilename(),
            'revision' => $file->getRevision(),
            'category' => $file->getCategory(),
            'created_at' => $file->getCreatedAt()->format(\DateTime::ISO8601),
            'content_type' => $file->getContentType(),
            'contexts' => $contextItems
        );
    }
}
