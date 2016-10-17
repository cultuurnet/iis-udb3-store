<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 29.09.16
 * Time: 09:08
 */

namespace CultuurNet\UDB3\IISStore\ReadModel\Commands;

class AbstractCommand
{
    /**
     * @var string
     */
    protected $itemId;

    /**
     * @var externalId
     */
    protected $externalId;

    /**
     * AbstractCommand constructor.
     * @param string $itemId
     * @param string externalId
     */
    public function __construct($itemId, $externalId)
    {
        $this->itemId = $itemId;
        $this->externalId =$externalId;
    }
}
