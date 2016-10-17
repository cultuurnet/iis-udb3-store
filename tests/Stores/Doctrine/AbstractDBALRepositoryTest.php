<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\DBALTestConnectionTrait;
use Doctrine\DBAL\Query\QueryBuilder;
use ValueObjects\String\String as StringLiteral;

abstract class AbstractBaseDBALRepositoryTest extends \PHPUnit_Framework_TestCase
{
    use DBALTestConnectionTrait;

    /**
     * @var StringLiteral
     */
    protected $tableName;

    /**
     * @var AbstractDBALRepository
     */
    private $abstractDBALRepository;

    protected function setUp()
    {

    }

    /**
     * @param string $tableName
     * @param array $rows
     */
    private function insertTableData($tableName, $rows)
    {
        $q = $this->getConnection()->createQueryBuilder();

        $schema = $this->getConnection()->getSchemaManager()->createSchema();

        $columns = $schema
            ->getTable($tableName)
            ->getColumns();

        $values = [];
        foreach ($columns as $column) {
            $values[$column->getName()] = '?';
        }

        $q->insert($tableName)
            ->values($values);

        foreach ($rows as $row) {
            $parameters = [];
            foreach (array_keys($values) as $columnName) {
                $parameters[] = $row->$columnName;
            }

            $q->setParameters($parameters);

            $q->execute();
        }
    }

    /**
     * @return QueryBuilder
     */
    public function createQueryBuilder()
    {
        return $this->connection->createQueryBuilder();
    }

    /**
     * @return StringLiteral
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @test
     */
    public function it_stores_a_connection()
    {
    }

    /**
     * @test
     */
    public function it_stores_a_table_name()
    {
    }

    /**
     * @param array $expectedData
     * @param string $tableName
     */
    private function assertTableData($expectedData, $tableName)
    {
        $expectedData = array_values($expectedData);

        $results = $this->getConnection()->executeQuery('SELECT * from ' . $tableName);

        $actualData = $results->fetchAll(PDO::FETCH_OBJ);

        $this->assertEquals(
            $expectedData,
            $actualData
        );
    }
}
