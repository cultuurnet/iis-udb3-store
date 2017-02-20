<?php

namespace CultuurNet\UDB3\IISStore\Stores;

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

    /**
     * StoreRepository constructor.
     * @param LoggingRepositoryInterface $loggingRepository
     * @param RelationsRepositoryInterface $relationsRepository
     * @param XmlRepositoryInterface $xmlRepository
     */
    public function __construct(
        LoggingRepositoryInterface $loggingRepository,
        RelationsRepositoryInterface $relationsRepository,
        XmlRepositoryInterface $xmlRepository
    ) {
        $this->loggingRepository = $loggingRepository;
        $this->relationsRepository = $relationsRepository;
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
        return $this->relationsRepository->getEventCdbid($externalId);
    }

    /**
     * @inheritdoc
     */
    public function storeRelations(UUID $eventUuid, StringLiteral $externalId, $isUpdate)
    {
        return $this->relationsRepository->storeRelations($eventUuid, $externalId, $isUpdate);
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
