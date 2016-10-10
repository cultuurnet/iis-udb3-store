<?php

namespace CultuurNet\UDB3\IISStore\ReadModel\Index;

use ValueObjects\Identity\UUID;

interface RepositoryInterface
{
    /**
     * @param string $eventUuid
     * @param string $eventXml
     * @param bool $isUpdate
     */
    public function storeEventXml($eventUuid, $eventXml, $isUpdate);

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

    /**
     * @param string $externalId
     * @return UUID|null $cdbid
     */
    public function getEventCdbid($externalId);
}
