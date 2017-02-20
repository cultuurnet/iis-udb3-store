<?php

namespace CultuurNet\UDB3\IISStore\Stores;

use ValueObjects\DateTime\DateTime;
use ValueObjects\Identity\UUID;
use ValueObjects\StringLiteral\StringLiteral;

class StoreRepository implements RepositoryInterface
{
    /**
     * @var LoggingRepositoryInterface
     */
    private $loggingRepository;

    /**
     * @var RelationRepositoryInterface
     */
    private $relationRepository;

    /**
     * @var XmlRepositoryInterface
     */
    private $xmlRepository;

    /**
     * StoreRepository constructor.
     * @param LoggingRepositoryInterface $loggingRepository
     * @param RelationRepositoryInterface $relationRepository
     * @param XmlRepositoryInterface $xmlRepository
     */
    public function __construct(
        LoggingRepositoryInterface $loggingRepository,
        RelationRepositoryInterface $relationRepository,
        XmlRepositoryInterface $xmlRepository
    ) {
        $this->loggingRepository = $loggingRepository;
        $this->relationRepository = $relationRepository;
        $this->xmlRepository = $xmlRepository;
    }

    /**
     * @inheritdoc
     */
    public function storeEventXml(UUID $eventUuid, StringLiteral $eventXml, $isUpdate)
    {
        return $this->xmlRepository->storeEventXml($eventUuid, $eventXml, $isUpdate);
    }

    /**
     * @inheritdoc
     */
    public function getEventCdbid(StringLiteral $externalId)
    {
        return $this->relationRepository->getEventCdbid($externalId);
    }

    /**
     * @inheritdoc
     */
    public function storeRelation(UUID $eventUuid, StringLiteral $externalId, $isUpdate)
    {
        return $this->relationRepository->storeRelation($eventUuid, $externalId, $isUpdate);
    }

    /**
     * @inheritdoc
     */
    public function saveStatus(
        UUID $eventUuid,
        DateTime $eventCreated
    ) {
        $this->saveStatus($eventUuid, $eventCreated);
    }

    /**
     * @inheritdoc
     */
    public function updateStatus(
        UUID $eventUuid,
        DateTime $eventUpdated
    ) {
        $this->loggingRepository->updateStatus($eventUuid, $eventUpdated);
    }

    /**
     * @inheritdoc
     */
    public function publishStatus(
        UUID $eventUuid,
        DateTime $eventPublished
    ) {
        $this->loggingRepository->publishStatus($eventUuid, $eventPublished);
    }
}
