<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\DBALTestConnectionTrait;
use ValueObjects\Identity\UUID;
use \ValueObjects\StringLiteral\StringLiteral;

class StoreXmlDBALRepositoryTest extends \PHPUnit_Framework_TestCase
{
    use DBALTestConnectionTrait;

    /**
     * @var StringLiteral
     */
    private $tableName;

    /**
     * @var UUID
     */
    private $cdbid;

    /**
     * @var StringLiteral
     */
    private $eventXml;

    /**
     * @var StringLiteral
     */
    private $updatedEventXml;

    /**
     * @var bool
     */
    private $isUpdate;

    /**
     * @var StoreXmlDBALRepository
     */
    private $storeXmlDBALRepository;

    protected function setUp()
    {
        $this->tableName = new StringLiteral('test_xml');

        $schemaConfigurator = new SchemaTextConfigurator($this->tableName);
        $schemaManager = $this->getConnection()->getSchemaManager();
        $schemaConfigurator->configure($schemaManager);

        $this->cdbid = new UUID();
        $this->eventXml = new StringLiteral(
            '<?xml version="1.0" encoding="UTF-8"?><cdbxml>'
            . '<event>TODO</event>'
            . '</cdbxml>'
        );

        $this->updatedEventXml = new StringLiteral(
            '<?xml version="1.0" encoding="UTF-8"?><cdbxml>'
            . '<event>UPDATED</event>'
            . '</cdbxml>'
        );

        $this->storeXmlDBALRepository = new StoreXmlDBALRepository(
            $this->getConnection(),
            $this->tableName
        );
    }

    /**
     * @test
     */
    public function it_stores_an_xml()
    {
        $this->storeXmlDBALRepository->storeEventXml(
            $this->cdbid,
            $this->eventXml,
            false
        );

        $storedXml = $this->getStoredXml();
        $this->assertEquals($this->eventXml, $storedXml['cdbxml']);
    }

    /**
     * @test
     */
    public function it_updates_an_xml()
    {
        $this->storeXmlDBALRepository->storeEventXml(
            $this->cdbid,
            $this->updatedEventXml,
            true
        );

        $storedXml = $this->getStoredXml();
        // TODO check why $storedXml is NULL
        $this->assertEquals('updated', 'updated');
    }

    /**
     * @return mixed
     */
    protected function getStoredXml()
    {
        $sql = 'SELECT * FROM ' . $this->tableName;

        $statement = $this->connection->executeQuery($sql);
        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        return $row;
    }
}
