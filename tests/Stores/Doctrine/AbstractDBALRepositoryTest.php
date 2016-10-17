<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\DBALTestConnectionTrait;
use CultuurNet\UDB3\IISStore\Stores\Doctrine\SchemaLogConfigurator;
use ValueObjects\String\String as StringLiteral;

abstract class BaseDBALRepositoryTest extends \PHPUnit_Framework_TestCase
{
    use DBALTestConnectionTrait;

    /**
     * @var StringLiteral
     */
    private $tableName;

    protected function setUp()
    {
        $this->tableName = new StringLiteral('test_logging');

        $schemaConfigurator = new SchemaLogConfigurator($this->tableName);

        $schemaManager = $this->getConnection()->getSchemaManager();

        $schemaConfigurator->configure($schemaManager);
    }

    /**
     * @test
     */
    public function it_stores_a_connection()
    {
        $this->assertEquals(
            $this->connection,
            $this->abstractDBALRepository->getConnection()
        );
    }

    /**
     * @test
     */
    public function it_stores_a_table_name()
    {
        $this->assertEquals(
            $this->tableName,
            $this-> abstractDBALRepository->getTableName()
        );
    }

    /**
     * @test
     */
    public function it_creates_a_query_builder()
    {
        $this->assertNotNull(
            $this->abstractDBALRepository->createQueryBuilder()
        );
    }
}
