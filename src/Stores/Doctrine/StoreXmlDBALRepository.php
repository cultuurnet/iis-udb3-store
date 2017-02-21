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
    public function storeEventXml(UUID $eventUuid, StringLiteral $eventXml, $isUpdate)
    {
        $queryBuilder = $this->createQueryBuilder();

        if ($isUpdate) {
            $expr = $this->getConnection()->getExpressionBuilder();

            $queryBuilder->update($this->getTableName()->toNative())
                ->where($expr->eq(SchemaXmlConfigurator::UUID_COLUMN, ':uuid'))
                ->set(SchemaXmlConfigurator::UUID_COLUMN, ':uuid')
                ->set(SchemaXmlConfigurator::XML_COLUMN, ':cdbxml')
                ->set(SchemaXmlConfigurator::IS_UPDATE_COLUMN, ':update')
                ->setParameter('uuid', $eventUuid->toNative())
                ->setParameter('cdbxml', $eventXml->toNative())
                ->setParameter('update', $isUpdate ? 1 : 0);
        } else {
            $queryBuilder->insert($this->getTableName()->toNative())
                ->values([
                    SchemaXmlConfigurator::UUID_COLUMN => '?',
                    SchemaXmlConfigurator::XML_COLUMN => '?',
                    SchemaXmlConfigurator::IS_UPDATE_COLUMN => '?'
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
