<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\Stores\LoggingRepositoryInterface;
use ValueObjects\DateTime\DateTime;
use ValueObjects\Identity\UUID;

class StoreLoggingDBALRepository extends AbstractDBALRepository implements LoggingRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function saveStatus(
        UUID $eventUuid,
        DateTime $eventCreated
    ) {
        $queryBuilder = $this->createQueryBuilder();
        $queryBuilder->insert($this->getTableName()->toNative())
            ->values([
                SchemaLogConfigurator::UUID_COLUMN => '?',
                SchemaLogConfigurator::CREATE_COLUMN => '?',
            ])
            ->setParameters([
                $eventUuid,
                $eventCreated->toNativeDateTime(),
            ]);

        $queryBuilder->execute();
    }

    /**
     * @inheritdoc
     */
    public function updateStatus(
        UUID $eventUuid,
        DateTime $eventUpdated
    ) {
        $expr = $this->getConnection()->getExpressionBuilder();

        $queryBuilder->update($this->getTableName()->toNative())
            ->where($expr->eq(SchemaLogConfigurator::UUID_COLUMN, ':cdbid'))
            ->set(SchemaLogConfigurator::UPDATED_COLUMN, ':updated')
            ->setParameter('updated', $eventUpdated);
        $queryBuilder->execute();
    }

    /**
     * @inheritdoc
     */
    public function publishStatus(
        UUID $eventUuid,
        DateTime $eventPublished
    ) {
        $expr = $this->getConnection()->getExpressionBuilder();

        $queryBuilder->update($this->getTableName()->toNative())
            ->where($expr->eq(SchemaLogConfigurator::UUID_COLUMN, ':cdbid'))
            ->set(SchemaLogConfigurator::PUBLISHED_COLUMN, ':published')
            ->setParameter('published', $eventPublished);
        $queryBuilder->execute();
    }
}
