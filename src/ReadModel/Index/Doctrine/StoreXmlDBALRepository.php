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

class StoreXmlDBALRepository extends AbstractDBALRepository implements XmlRepositoryInterface
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
