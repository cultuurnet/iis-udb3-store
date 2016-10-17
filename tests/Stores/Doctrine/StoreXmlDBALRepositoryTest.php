<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\Stores\XmlRepositoryInterface;
use ValueObjects\Identity\UUID;
use \ValueObjects\String\String as StringLiteral;

class StoreXmlDBALRepositoryTest extends AbstractBaseDBALRepositoryTest implements XmlRepositoryInterface
{
    /**
     * @var UUID
     */
    private $cdbid;

    /**
     * @var StringLiteral
     */
    private $eventXml;

    /**
     * @var bool
     */
    private $isUpdate;

    protected function setUp()
    {
        $this->tableName = new StringLiteral('test_xml');
        $schemaConfigurator = new SchemaLogConfigurator($this->tableName);
        $schemaManager = $this->getConnection()->getSchemaManager();
        $schemaConfigurator->configure($schemaManager);

        $this->cdbid = new UUID();
        $this->eventXml= new StringLiteral(
            '<?xml version="1.0" encoding="UTF-8"?><cdbxml>'
            . '<event>TODO</event>'
            . '</cdbxml>'
        );
        $this->isUpdate =true;

        $this->storeEventXml($this->cdbid, $this->eventXml, $this->isUpdate);

        parent::setUp();
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
            ->from($this->getTableName()-toNative())
            ->where($whereId)
            ->setParameter([$externalId]);

        return $this->getResult($queryBuilder);
    }

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
     * @test
     */
    public function it_should_store_an_xml()
    {
       // echo $this->getEventCdbid();
    }
}
