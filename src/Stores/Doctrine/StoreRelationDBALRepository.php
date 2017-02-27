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
    public function saveRelation(UUID $eventCdbid, StringLiteral $externalId)
    {
        $queryBuilder = $this->createQueryBuilder();

        $queryBuilder->insert($this->getTableName()->toNative())
            ->values([
                SchemaRelationConfigurator::CDBID_COLUMN => '?',
                SchemaRelationConfigurator::EXTERNAL_ID_COLUMN => '?'
            ])
            ->setParameters([
                $eventCdbid,
                $externalId
            ]);

        $queryBuilder->execute();
    }

    /**
     * @inheritdoc
     */
    public function getEventCdbid(StringLiteral $externalId)
    {
        $whereId = SchemaRelationConfigurator::EXTERNAL_ID_COLUMN . ' = :externalId';

        $queryBuilder = $this->createQueryBuilder();
        $queryBuilder->select(SchemaRelationConfigurator::CDBID_COLUMN)
            ->from($this->getTableName()->toNative())
            ->where($whereId)
            ->setParameter('externalId', $externalId);

        $statement = $queryBuilder->execute();
        $resultSet = $statement->fetchAll();
        if (empty($resultSet)) {
            return null;
        } else {
            return UUID::fromNative($resultSet[0]['cdbid']);
        }
    }
}
