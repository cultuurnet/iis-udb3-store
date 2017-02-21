<?php

namespace CultuurNet\UDB3\IISStore\Stores;

use ValueObjects\Identity\UUID;

interface LoggingRepositoryInterface
{
    /**
     * @param UUID $eventCdbid
     * @param \DateTimeInterface $createdDateTime
     */
    public function saveCreated(
        UUID $eventCdbid,
        \DateTimeInterface $createdDateTime
    );

    /**
     * @param UUID $eventCdbid
     * @param \DateTimeInterface $updatedDateTime
     */
    public function saveUpdated(
        UUID $eventCdbid,
        \DateTimeInterface $updatedDateTime
    );

    /**
     * @param UUID $eventCdbid
     * @param \DateTimeInterface $publishedDateTime
     */
    public function savePublished(
        UUID $eventCdbid,
        \DateTimeInterface $publishedDateTime
    );
}
