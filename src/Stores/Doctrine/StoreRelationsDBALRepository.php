<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\Stores\RelationsRepositoryInterface;
use ValueObjects\Identity\UUID;
use ValueObjects\String\String as StringLiteral;

class StoreRelationsDBALRepository extends AbstractDBALRepository implements RelationsRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function storeRelations(UUID $eventUuid, StringLiteral $externalId, $isUpdate)
    {
        $queryBuilder = $this->createQueryBuilder();
        $queryBuilder->insert($this->getTableName()->toNative())
            ->values([
                SchemaRelationsConfigurator::UUID_COLUMN => '?',
                SchemaRelationsConfigurator::EXTERNAL_ID_COLUMN => '?'
            ])
            ->setParameters([
                $eventUuid,
                $externalId
            ]);

        $queryBuilder->execute();
    }

    /**
     * @inheritdoc
     */
    public function getEventCdbid(StringLiteral $externalId)
    {
        $whereId = SchemaRelationsConfigurator::EXTERNAL_ID_COLUMN . ' = :externalId';

        $queryBuilder = $this->createQueryBuilder();
        $queryBuilder->select(SchemaRelationsConfigurator::UUID_COLUMN)
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
