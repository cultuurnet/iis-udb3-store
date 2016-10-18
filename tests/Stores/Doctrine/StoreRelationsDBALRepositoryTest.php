<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\DBALTestConnectionTrait;
use ValueObjects\Identity\UUID;
use \ValueObjects\String\String as StringLiteral;

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
    }

    /**
     * @test
     */
    public function it_stores_a_relation()
    {
        $this->storeRelationsDBALRepository->storeRelations(
            $this->cdbid,
            $this->external_id
        );

//        $storedRelation = $this->getStoredRelation();
    }

    /**
     * @return mixed
     */
    protected function getStoredRelation()
    {
        $sql = 'SELECT * FROM ' . $this->tableName;

        $statement = $this->connection->executeQuery($sql);
        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        return $row[1];
    }
}
