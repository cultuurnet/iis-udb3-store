<?php

namespace CultuurNet\UDB3\IISStore\Stores;

use ValueObjects\DateTime\DateTime;
use ValueObjects\Identity\UUID;

interface LoggingRepositoryInterface
{
    /**
     * @param UUID $eventUuid
     * @param DateTime $eventCreated
     * @param DateTime $eventUpdated
     * @param DateTime $eventPublished
     */
    public function storeStatus(
        UUID $eventUuid,
        DateTime $eventCreated,
        DateTime $eventUpdated,
        DateTime $eventPublished
    );
}
