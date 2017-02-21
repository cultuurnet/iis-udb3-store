<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\DBALTestConnectionTrait;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
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
     * @var StoreXmlDBALRepository
     */
    private $storeXmlDBALRepository;

    protected function setUp()
    {
        $this->tableName = new StringLiteral('test_xml');

        $schemaConfigurator = new SchemaXmlConfigurator($this->tableName);
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
    public function it_saves_an_xml()
    {
        $this->storeXmlDBALRepository->saveEventXml(
            $this->cdbid,
            $this->eventXml
        );

        $storedRow = $this->getStoredRow();

        $this->assertEquals($this->eventXml, $storedRow['cdbxml']);
    }

    /**
     * @test
     */
    public function it_updates_an_xml()
    {
        $this->storeXmlDBALRepository->saveEventXml(
            $this->cdbid,
            $this->eventXml
        );

        $this->storeXmlDBALRepository->updateEventXml(
            $this->cdbid,
            $this->updatedEventXml
        );

        $storedRow = $this->getStoredRow();

        $this->assertEquals($this->updatedEventXml, $storedRow['cdbxml']);
    }

    /**
     * @test
     */
    public function it_can_get_an_xml_based_on_event_cdbid()
    {
        $this->storeXmlDBALRepository->saveEventXml(
            $this->cdbid,
            $this->eventXml
        );

        $storedXml = $this->storeXmlDBALRepository->getEventXml($this->cdbid);

        $this->assertEquals($this->eventXml, $storedXml);
    }

    /**
     * @test
     */
    public function it_returns_null_when_no_xml_found_for_event_cdbid()
    {
        $storedXml = $this->storeXmlDBALRepository->getEventXml($this->cdbid);

        $this->assertNull($storedXml);
    }

    /**
     * @test
     */
    public function it_has_a_unique_contraint_on_event_cdbid()
    {
        $this->expectException(UniqueConstraintViolationException::class);

        $this->storeXmlDBALRepository->saveEventXml(
            $this->cdbid,
            $this->eventXml
        );

        $this->storeXmlDBALRepository->saveEventXml(
            $this->cdbid,
            $this->updatedEventXml
        );
    }

    /**
     * @return mixed
     */
    protected function getStoredRow()
    {
        $sql = 'SELECT * FROM ' . $this->tableName;

        $statement = $this->connection->executeQuery($sql);
        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        return $row;
    }
}
