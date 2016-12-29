<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzAccordionBlockBundle\Exception;

use Exception;
use RuntimeException;

/**
 * invalid block attribute exception.
 */
class InvalidBlockAttributeException extends RuntimeException
{
    /**
     * @param string $blockType
     * @param string $attribute
     * @param string $message
     * @param Exception $previous
     */
    public function __construct($blockType, $attribute, $message, Exception $previous = null)
    {
        parent::__construct(
            'Invalid attribute ' . $attribute . ' in ' . $blockType . ' Block. Error message: ' . $message,
            0,
            $previous
        );
    }
}
