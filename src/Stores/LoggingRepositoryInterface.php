<?php

namespace CultuurNet\UDB3\IISStore\Stores;

use ValueObjects\DateTime\DateTime;
use ValueObjects\Identity\UUID;

interface LoggingRepositoryInterface
{
    /**
     * @param UUID $eventUuid
     * @param null|DateTime $eventCreated
     */
    public function saveStatus(
        UUID $eventUuid,
        DateTime $eventCreated
    );

    /**
     * @param UUID $eventUuid
     * @param null|DateTime $eventUpdated
     */
    public function updateStatus(
        UUID $eventUuid,
        DateTime $eventUpdated
    );

    /**
     * @param UUID $eventUuid
     * @param DateTime $eventPublished
     */
    public function publishStatus(
        UUID $eventUuid,
        DateTime $eventPublished
    );
}
