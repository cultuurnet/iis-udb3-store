<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\Stores\XmlRepositoryInterface;
use ValueObjects\DateTime\DateTime;
use ValueObjects\Identity\UUID;
use ValueObjects\String\String as StringLiteral;

class StoreXmlDBALRepository extends AbstractDBALRepository implements XmlRepositoryInterface
{
    /**
     * @param UUID $eventUuid
     * @param StringLiteral $eventXml
     * @param bool $isUpdate
     */
    public function storeEventXml(UUID $eventUuid, StringLiteral $eventXml, $isUpdate)
    {
        $queryBuilder = $this->createQueryBuilder();

        if ($isUpdate) {
            $expr = $this->getConnection()->getExpressionBuilder();

            $queryBuilder->update($this->getTableName()->toNative())
                ->where($expr->eq(SchemaTextConfigurator::UUID_COLUMN, ':uuid'))
                ->set(SchemaTextConfigurator::UUID_COLUMN, ':uuid')
                ->set(SchemaTextConfigurator::XML_COLUMN, ':cdbxml')
                ->set(SchemaTextConfigurator::IS_UPDATE_COLUMN, ':update')
                ->setParameter('uuid', $eventUuid->toNative())
                ->setParameter('cdbxml', $eventXml->toNative())
                ->setParameter('update', $isUpdate ? 1 : 0);
        } else {
            $queryBuilder->insert($this->getTableName()->toNative())
                ->values([
                    SchemaTextConfigurator::UUID_COLUMN => '?',
                    SchemaTextConfigurator::XML_COLUMN => '?',
                    SchemaTextConfigurator::IS_UPDATE_COLUMN => '?'
                ])
                ->setParameters([
                    $eventUuid->toNative(),
                    $eventXml->toNative(),
                    $isUpdate ? 1 : 0
                ]);
        }
        $queryBuilder->execute();
    }
}
