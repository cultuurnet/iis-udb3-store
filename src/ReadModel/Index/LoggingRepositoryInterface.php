<?php

namespace CultuurNet\UDB3\IISStore\ReadModel\Index;

use ValueObjects\DateTime;
use ValueObjects\Identity\UUID;

interface LoggingRepositoryInterface
{
    /**
     * @param UUID $eventUuid
     * @param DateTime\DateTime $eventCreated
     * @param DateTime\DateTime $eventUpdated
     * @param DateTime\DateTime $eventPublished
     */
    public function storeStatus($eventUuid, $eventCreated, $eventUpdated, $eventPublished);

}
