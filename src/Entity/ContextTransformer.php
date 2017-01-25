<?php

namespace Fei\Service\Filer\Entity;

use League\Fractal\TransformerAbstract;

/**
 * Class ContextTransformer
 *
 * @package Fei\Service\Filer\Entity
 */
class ContextTransformer extends TransformerAbstract
{
    public function transform(Context $context)
    {
        return array(
            'id' => (int)$context->getId(),
            'key' => $context->getKey(),
            'value' => $context->getValue()
        );
    }
}
