<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\Stores\RelationsRepositoryInterface;
use ValueObjects\Identity\UUID;
use ValueObjects\String\String as StringLiteral;

class StoreRelationsDBALRepository extends AbstractDBALRepository implements RelationsRepositoryInterface
{
    /**
     * @param UUID $eventUuid
     * @param StringLiteral $externalId
     */
    public function storeRelations(UUID $eventUuid, StringLiteral $externalId)
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
     * @param StringLiteral $externalId
     * @return UUID|null $cdbid
     */
    public function getEventCdbid(StringLiteral $externalId)
    {
        $whereId = SchemaRelationsConfigurator::EXTERNAL_ID_COLUMN . ' = ?';

        $queryBuilder = $this->createQueryBuilder();
        $queryBuilder->select(SchemaRelationsConfigurator::UUID_COLUMN)
            ->from($this->getTableName()->toNative())
            ->where($whereId)
            ->setParameter('?', $externalId);

        return $this->getResult($queryBuilder);
    }
}
