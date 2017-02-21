<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\Stores\LoggingRepositoryInterface;
use ValueObjects\Identity\UUID;

class StoreLoggingDBALRepository extends AbstractDBALRepository implements LoggingRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function saveCreated(
        UUID $eventCdbid,
        \DateTimeInterface $createdDateTime
    ) {
        $queryBuilder = $this->createQueryBuilder();
        $queryBuilder->insert($this->getTableName()->toNative())
            ->values([
                SchemaLogConfigurator::CDBID_COLUMN => '?',
                SchemaLogConfigurator::CREATE_COLUMN => '?',
            ])
            ->setParameters([
                $eventCdbid,
                $this->toDateTimeString($createdDateTime),
            ]);

        $queryBuilder->execute();
    }

    /**
     * @inheritdoc
     */
    public function saveUpdated(
        UUID $eventCdbid,
        \DateTimeInterface $updatedDateTime
    ) {
        $queryBuilder = $this->createQueryBuilder();
        $queryBuilder->insert($this->getTableName()->toNative())
            ->values([
                SchemaLogConfigurator::CDBID_COLUMN => '?',
                SchemaLogConfigurator::UPDATED_COLUMN => '?',
            ])
            ->setParameters([
                $eventCdbid,
                $this->toDateTimeString($updatedDateTime),
            ]);

        $queryBuilder->execute();
    }

    /**
     * @inheritdoc
     */
    public function savePublished(
        UUID $eventCdbid,
        \DateTimeInterface $publishedDateTime
    ) {
        $queryBuilder = $this->createQueryBuilder();
        $queryBuilder->insert($this->getTableName()->toNative())
            ->values([
                SchemaLogConfigurator::CDBID_COLUMN => '?',
                SchemaLogConfigurator::PUBLISHED_COLUMN => '?',
            ])
            ->setParameters([
                $eventCdbid,
                $this->toDateTimeString($publishedDateTime),
            ]);

        $queryBuilder->execute();
    }

    /**
     * @param \DateTimeInterface $dateTime
     * @return string
     */
    private function toDateTimeString(\DateTimeInterface $dateTime)
    {
        return $dateTime->format(\DateTime::ATOM);
    }
}
