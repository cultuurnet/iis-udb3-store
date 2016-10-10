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
     * @param bool $isUpdate
     */
    public function storeEventXml($eventUuid, $eventXml, $isUpdate)
    {
        $queryBuilder = $this->createQueryBuilder();

        if ($isUpdate) {
            $expr = $this->getConnection()->getExpressionBuilder();

            $queryBuilder->update($this->getTableName()->toNative())
                ->where($expr->eq(SchemaTextConfigurator::UUID_COLUMN, ':uuid'))
                ->set(SchemaTextConfigurator::UUID_COLUMN, ':uuid')
                ->set(SchemaTextConfigurator::IS_UPDATE_COLUMN, ':update')
                ->setParameter('uuid', $eventUuid)
                ->setParameter('cdbxml', $eventXml)
                ->setParameter('update', $isUpdate);
        } else {
            $queryBuilder->insert($this->getTableName()->toNative())
                ->values([
                    SchemaTextConfigurator::UUID_COLUMN => '?',
                    SchemaTextConfigurator::XML_COLUMN => '?',
                    SchemaTextConfigurator::IS_UPDATE_COLUMN => '?'
                ])
                ->setParameters([
                    $eventUuid,
                    $eventXml->toNativeDateTime(),
                    $isUpdate
                ]);
        }
        $queryBuilder->execute();
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

        $queryBuilder->execute();
    }

    /**
     * @param string $externalId
     * @return UUID|null $cdbid
     */
    public function getEventCdbid($externalId)
    {
        $whereId = SchemaRelationsConfigurator::EXTERNAL_ID_COLUMN . ' = ?';

        $queryBuilder = $this->createQueryBuilder();
        $queryBuilder->select(SchemaRelationsConfigurator::UUID_COLUMN)
            ->from($this->getTableName()-toNative())
            ->where($whereId)
            ->setParameter([$externalId]);

        return $this->getResult($queryBuilder);
    }
}
