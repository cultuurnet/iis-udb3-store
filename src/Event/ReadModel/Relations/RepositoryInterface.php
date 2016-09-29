<?php


namespace CultuurNet\UDB3\IISStore\Event\ReadModel\Relations;

use ValueObjects\DateTime\DateTime;

interface RepositoryInterface
{
    /**
     * @param string $eventUuid
     * @param string $eventXml
     */
    public function storeEventXml($eventUuid, $eventXml);

    /**
     * @param string $eventUuid
     * @param string $externalId
     */
    public function storeRelations($eventUuid, $externalId);

    /**
     * @param string $eventUuid
     * @param DateTime $eventCreated
     * @param DateTime $eventUpdated
     * @param DateTime $eventPublished
     */
    public function storeStatus($eventUuid, $eventCreated, $eventUpdated, $eventPublished);
}
