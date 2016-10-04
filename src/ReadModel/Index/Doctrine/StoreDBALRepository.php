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

class StoreDBALRepository extends AbstractDBALRepository implements RepositoryInterface
{
    /**
     * @param string $eventUuid
     * @param string $eventXml
     */
    public function storeEventXml($eventUuid, $eventXml)
    {
        // TODO: Implement storeEventXml() method.
    }

    /**
     * @param string $eventUuid
     * @param string $externalId
     */
    public function storeRelations($eventUuid, $externalId)
    {
        // TODO: Implement storeRelations() method.
    }

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
    }

    /**
     * @param string $externalId
     * @return UUID|null $cdbid
     */
    public function getEventCdbid($externalId)
    {
        $whereId = SchemaRelationsConfigurator::EXTERNAL_ID_COLUMN . ' = ?';

        $queryBuilder = $this->createQueryBuilder();
        $queryBuilder->from($this->getTableName()->toNative())
            ->select(SchemaRelationsConfigurator::UUID_COLUMN)
            ->where($whereId)
            ->setParameter([$externalId]);
    }
}
