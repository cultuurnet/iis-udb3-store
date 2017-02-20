<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\DBALTestConnectionTrait;
use ValueObjects\Identity\UUID;
use \ValueObjects\StringLiteral\StringLiteral;

class StoreRelationsDBALRepositoryTest extends \PHPUnit_Framework_TestCase
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
    private $external_id;

    /**
     * @var StoreRelationsDBALRepository
     */
    private $storeRelationsDBALRepository;

    /**
     * @var array
     */
    private $storedRelationRow;

    protected function setUp()
    {
        $this->tableName = new StringLiteral('test_relation');

        $schemaConfigurator = new SchemaRelationsConfigurator($this->tableName);
        $schemaManager = $this->getConnection()->getSchemaManager();
        $schemaConfigurator->configure($schemaManager);

        $this->cdbid = new UUID();
        $this->external_id = new StringLiteral('CDB:Example123');

        $this->storeRelationsDBALRepository = new StoreRelationsDBALRepository(
            $this->getConnection(),
            $this->tableName
        );

        $this->storeRelationsDBALRepository->storeRelations(
            $this->cdbid,
            $this->external_id,
            false
        );

        $this->storedRelationRow = $this->getStoredRelation();
    }

    /**
     * @test
     */
    public function it_stores_the_uuid()
    {
        $this->assertEquals(
            $this->storedRelationRow[SchemaRelationsConfigurator::UUID_COLUMN],
            $this->cdbid
        );
    }

    /**
     * @test
     */
    public function it_stores_the_external_id()
    {
        $this->assertEquals(
            $this->storedRelationRow[SchemaRelationsConfigurator::EXTERNAL_ID_COLUMN],
            $this->external_id
        );
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
