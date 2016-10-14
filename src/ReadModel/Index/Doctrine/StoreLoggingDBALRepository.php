<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 04.10.16
 * Time: 11:43
 */

namespace CultuurNet\UDB3\IISStore\ReadModel\Index;

use ValueObjects\DateTime\DateTime;
use ValueObjects\Identity\UUID;

class StoreLoggingDBALRepository extends AbstractDBALRepository implements LoggingRepositoryInterface
{
    /**
     * @param string $eventUuid
     * @param DateTime $eventCreated
     * @param DateTime $eventUpdated
     * @param DateTime $eventPublished
     */
    public function storeStatus($eventUuid, $eventCreated, $eventUpdated, $eventPublished)
    {
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
