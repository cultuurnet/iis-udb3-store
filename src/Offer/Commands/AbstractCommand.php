<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 29.09.16
 * Time: 09:08
 */

namespace CultuurNet\UDB3\IISStore\Offer\Commands;

class AbstractCommand
{
    /**
     * @var string
     */
    protected $itemId;

    /**
     * AbstractCommand constructor.
     * @param string $itemId
     */
    public function __construct($itemId)
    {
        $this->itemId = $itemId;
    }
}