<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\DBALTestConnectionTrait;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use ValueObjects\Identity\UUID;
use \ValueObjects\StringLiteral\StringLiteral;

class StoreRelationDBALRepositoryTest extends \PHPUnit_Framework_TestCase
{
    use DBALTestConnectionTrait;

    /**
     * @var StringLiteral
     */
    private $tableName;

    /**
     * @var UUID
     */
    private $eventCdbid;

    /**
     * @var StringLiteral
     */
    private $externalId;

    /**
     * @var StoreRelationDBALRepository
     */
    private $storeRelationDBALRepository;

    /**
     * @var array
     */
    private $storedRelationRow;

    protected function setUp()
    {
        $this->tableName = new StringLiteral('test_relation');

        $schemaConfigurator = new SchemaRelationConfigurator($this->tableName);
        $schemaManager = $this->getConnection()->getSchemaManager();
        $schemaConfigurator->configure($schemaManager);

        $this->eventCdbid = new UUID();
        $this->externalId = new StringLiteral('CDB:Example123');

        $this->storeRelationDBALRepository = new StoreRelationDBALRepository(
            $this->getConnection(),
            $this->tableName
        );

        $this->storeRelationDBALRepository->saveRelation(
            $this->eventCdbid,
            $this->externalId
        );

        $this->storedRelationRow = $this->getStoredRelation();
    }

    /**
     * @test
     */
    public function it_stores_the_uuid()
    {
        $this->assertEquals(
            $this->storedRelationRow[SchemaRelationConfigurator::CDBID_COLUMN],
            $this->eventCdbid
        );
    }

    /**
     * @test
     */
    public function it_stores_the_external_id()
    {
        $this->assertEquals(
            $this->storedRelationRow[SchemaRelationConfigurator::EXTERNAL_ID_COLUMN],
            $this->externalId
        );
    }

    /**
     * @test
     */
    public function it_has_a_unique_constraint_on_uuid()
    {
        $this->expectException(UniqueConstraintViolationException::class);

        $this->storeRelationDBALRepository->saveRelation(
            $this->eventCdbid,
            new StringLiteral('CDB:OtherExample')
        );
    }

    /**
     * @test
     */
    public function it_has_a_unique_constraint_on_external_id()
    {
        $this->expectException(UniqueConstraintViolationException::class);

        $this->storeRelationDBALRepository->saveRelation(
            new UUID(),
            $this->externalId
        );
    }

    /**
     * @test
     */
    public function it_can_get_the_cdbid_of_an_event()
    {
        $actualEventCdbid = $this->storeRelationDBALRepository->getEventCdbid(
            $this->externalId
        );

        $this->assertEquals($this->eventCdbid, $actualEventCdbid);
    }

    /**
     * @test
     */
    public function it_returns_null_for_relations_of_unknown_event_cdbid()
    {
        $actualEventCdbid = $this->storeRelationDBALRepository->getEventCdbid(
            new StringLiteral('CDB:OtherExample')
        );

        $this->assertNull($actualEventCdbid);
    }

    /**
     * @return mixed
     */
    protected function getStoredRelation()
    {
        $sql = 'SELECT * FROM ' . $this->tableName;

        $statement = $this->connection->executeQuery($sql);
        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        return $row;
    }
}
