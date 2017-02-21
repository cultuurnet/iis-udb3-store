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
    public function saveEventXml(UUID $eventCdbid, StringLiteral $eventXml)
    {
        $this->xmlRepository->saveEventXml($eventCdbid, $eventXml);
    }

    /**
     * @inheritdoc
     */
    public function updateEventXml(UUID $eventCdbid, StringLiteral $eventXml)
    {
        $this->xmlRepository->updateEventXml($eventCdbid, $eventXml);
    }

    /**
     * @inheritdoc
     */
    public function getEventXml(UUID $eventCdbid)
    {
        return $this->xmlRepository->getEventXml($eventCdbid);
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
    public function saveRelation(UUID $eventCdbid, StringLiteral $externalId)
    {
        $this->relationRepository->saveRelation($eventCdbid, $externalId);
    }

    /**
     * @inheritdoc
     */
    public function saveCreated(
        UUID $eventCdbid,
        \DateTimeInterface $createdDateTime
    ) {
        $this->loggingRepository->saveCreated($eventCdbid, $createdDateTime);
    }

    /**
     * @inheritdoc
     */
    public function saveUpdated(
        UUID $eventCdbid,
        \DateTimeInterface $updatedDateTime
    ) {
        $this->loggingRepository->saveUpdated($eventCdbid, $updatedDateTime);
    }

    /**
     * @inheritdoc
     */
    public function savePublished(
        UUID $eventCdbid,
        \DateTimeInterface $publishedDateTime
    ) {
        $this->loggingRepository->savePublished($eventCdbid, $publishedDateTime);
    }
}
