<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\Stores\LoggingRepositoryInterface;
use ValueObjects\DateTime\DateTime;
use ValueObjects\Identity\UUID;

class StoreLoggingDBALRepository extends AbstractDBALRepository implements LoggingRepositoryInterface
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
    ) {
        $queryBuilder = $this->createQueryBuilder();
        $queryBuilder->insert($this->getTableName()->toNative())
            ->values([
                SchemaLogConfigurator::UUID_COLUMN => '?',
                SchemaLogConfigurator::CREATE_COLUMN => '?',
                SchemaLogConfigurator::UPDATED_COLUMN => '?',
                SchemaLogConfigurator::PUBLISHED_COLUMN => '?'
            ])
            ->setParameters([
                $eventUuid,
                $eventCreated->toNativeDateTime(),
                $eventUpdated->toNativeDateTime(),
                $eventPublished->toNativeDateTime(),
            ]);

        $queryBuilder->execute();
    }
}
