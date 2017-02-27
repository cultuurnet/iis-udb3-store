<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\Stores\XmlRepositoryInterface;
use ValueObjects\Identity\UUID;
use ValueObjects\StringLiteral\StringLiteral;

class StoreXmlDBALRepository extends AbstractDBALRepository implements XmlRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function saveEventXml(UUID $eventUuid, StringLiteral $eventXml)
    {
        $queryBuilder = $this->createQueryBuilder();

        $queryBuilder->insert($this->getTableName()->toNative())
            ->values([
                SchemaXmlConfigurator::CDBID_COLUMN => '?',
                SchemaXmlConfigurator::XML_COLUMN => '?',
            ])
            ->setParameters([
                $eventUuid->toNative(),
                $eventXml->toNative(),
            ]);

        $queryBuilder->execute();
    }

    /**
     * @inheritdoc
     */
    public function updateEventXml(UUID $eventUuid, StringLiteral $eventXml)
    {
        $whereId = SchemaXmlConfigurator::CDBID_COLUMN . ' = :cdbid';

        $queryBuilder = $this->createQueryBuilder();

        $queryBuilder->update($this->getTableName()->toNative())
            ->set(
                SchemaXmlConfigurator::XML_COLUMN,
                $queryBuilder->expr()->literal($eventXml->toNative())
            )
            ->where($whereId)
            ->setParameters([
                SchemaXmlConfigurator::CDBID_COLUMN => $eventUuid->toNative(),
            ]);

        $queryBuilder->execute();
    }

    /**
     * @inheritdoc
     */
    public function getEventXml(UUID $eventCdbid)
    {
        $whereId = SchemaXmlConfigurator::CDBID_COLUMN . ' = :cdbid';

        $queryBuilder = $this->createQueryBuilder();
        $queryBuilder->select(SchemaXmlConfigurator::XML_COLUMN)
            ->from($this->getTableName()->toNative())
            ->where($whereId)
            ->setParameter('cdbid', $eventCdbid);

        $statement = $queryBuilder->execute();
        $resultSet = $statement->fetchAll();
        if (empty($resultSet)) {
            return null;
        } else {
            return StringLiteral::fromNative($resultSet[0][SchemaXmlConfigurator::XML_COLUMN]);
        }
    }
}
