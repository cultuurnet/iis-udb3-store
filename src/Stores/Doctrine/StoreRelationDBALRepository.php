<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\Stores\RelationRepositoryInterface;
use ValueObjects\Identity\UUID;
use ValueObjects\StringLiteral\StringLiteral;

class StoreRelationDBALRepository extends AbstractDBALRepository implements RelationRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function storeRelation(UUID $eventUuid, StringLiteral $externalId, $isUpdate)
    {
        $queryBuilder = $this->createQueryBuilder();
        if ($isUpdate) {
            $expr = $this->getConnection()->getExpressionBuilder();

            $queryBuilder->update($this->getTableName()->toNative())
                ->where($expr->eq(SchemaRelationConfigurator::EXTERNAL_ID_COLUMN, ':external_id'))
                    ->set(SchemaRelationConfigurator::UUID_COLUMN, ':uuid')
                    ->set(SchemaRelationConfigurator::EXTERNAL_ID_COLUMN, ':external_id')
                    ->setParameter('uuid', $eventUuid->toNative())
                    ->setParameter('external_id', $externalId->toNative());
        } else {
            $queryBuilder->insert($this->getTableName()->toNative())
                ->values([
                    SchemaRelationConfigurator::UUID_COLUMN => '?',
                    SchemaRelationConfigurator::EXTERNAL_ID_COLUMN => '?'
                ])
                ->setParameters([
                    $eventUuid,
                    $externalId
                ]);
        }

        $queryBuilder->execute();
    }

    /**
     * @inheritdoc
     */
    public function getEventCdbid(StringLiteral $externalId)
    {
        $whereId = SchemaRelationConfigurator::EXTERNAL_ID_COLUMN . ' = :externalId';

        $queryBuilder = $this->createQueryBuilder();
        $queryBuilder->select(SchemaRelationConfigurator::UUID_COLUMN)
            ->from($this->getTableName()->toNative())
            ->where($whereId)
            ->setParameter('externalId', $externalId);

        $result = $queryBuilder->execute();
        $resultSet = $result->fetchAll();
        if (empty($resultSet)) {
            return null;
        } else {
            return UUID::fromNative($resultSet[0]['cdbid']);
        }
    }
}
