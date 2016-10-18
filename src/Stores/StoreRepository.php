<?php

namespace CultuurNet\UDB3\IISStore\Stores;

use CultuurNet\UDB3\IISStore\Stores\Doctrine\StoreLoggingDBALRepository;
use CultuurNet\UDB3\IISStore\Stores\Doctrine\StoreRelationsDBALRepository;
use ValueObjects\DateTime\DateTime;
use ValueObjects\Identity\UUID;
use ValueObjects\String\String as StringLiteral;

class StoreRepository implements RepositoryInterface
{
    /**
     * @var LoggingRepositoryInterface
     */
    private $loggingRepository;

    /**
     * @var RelationsRepositoryInterface
     */
    private $relationsRepository;

    /**
     * @var XmlRepositoryInterface
     */
    private $xmlRepository;

    public function __construct()
    {
        $this->loggingRepository = new StoreLoggingDBALRepository();
        $this->relationsRepository =new StoreRelationsDBALRepository();
        $this->xmlRepository =new StoreXmlDBALRepository();
    }

    /**
     * @param UUID $eventUuid
     * @param StringLiteral $eventXml
     * @param bool $isUpdate
     */
    public function storeEventXml(UUID $eventUuid, StringLiteral $eventXml, $isUpdate)
    {
        return $this->xmlRepository->storeEventXml($eventUuid, $eventXml, $isUpdate);
    }

    /**
     * @param StringLiteral $externalId
     * @return UUID|null $cdbid
     */
    public function getEventCdbid(StringLiteral $externalId)
    {
        return $this->relationsRepository->getEventCdbid($externalId);
    }

    public function storeRelations(UUID $eventUuid, StringLiteral $externalId)
    {
        return $this->relationsRepository->storeRelations($eventUuid, $externalId);
    }

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
    ) {
        return $this->loggingRepository->storeStatus($eventUuid, $eventCreated, $eventUpdated, $eventPublished);
    }
}
