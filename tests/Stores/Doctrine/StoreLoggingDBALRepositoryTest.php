<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\DBALTestConnectionTrait;
use ValueObjects\Identity\UUID;
use \ValueObjects\StringLiteral\StringLiteral;

class StoreLoggingDBALRepositoryTest extends \PHPUnit_Framework_TestCase
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
     * @var \DateTime
     */
    private $eventCreated;

    /**
     * @var \DateTime
     */
    private $eventUpdated;

    /**
     * @var \DateTime
     */
    private $eventPublished;

    /**
     * @var StoreLoggingDBALRepository
     */
    private $storeLoggingDBALRepository;

    protected function setUp()
    {
        $this->tableName = new StringLiteral('test_logging');

        $schemaConfigurator = new SchemaLogConfigurator($this->tableName);
        $schemaManager = $this->getConnection()->getSchemaManager();
        $schemaConfigurator->configure($schemaManager);

        $this->eventCdbid = new UUID();

        $this->eventCreated = new \DateTime('2017-01-01T12:00:00');
        $this->eventUpdated = new \DateTime('2017-01-02T12:00:00');
        $this->eventPublished = new \DateTime('2017-01-03T12:00:00');

        $this->storeLoggingDBALRepository = new StoreLoggingDBALRepository(
            $this->getConnection(),
            $this->tableName
        );
    }

    /**
     * @test
     */
    public function it_can_save_created_status()
    {
        $this->storeLoggingDBALRepository->saveCreated(
            $this->eventCdbid,
            $this->eventCreated
        );

        $storedRow = $this->getStoredRow();

        $this->assertEquals(
            $this->eventCreated,
            new \DateTime($storedRow[SchemaLogConfigurator::CREATE_COLUMN])
        );
    }

    /**
     * @test
     */
    public function it_can_save_updated_status()
    {
        $this->storeLoggingDBALRepository->saveUpdated(
            $this->eventCdbid,
            $this->eventUpdated
        );

        $storedRow = $this->getStoredRow();

        $this->assertEquals(
            $this->eventUpdated,
            new \DateTime($storedRow[SchemaLogConfigurator::UPDATED_COLUMN])
        );
    }

    /**
     * @test
     */
    public function it_can_save_published_status()
    {
        $this->storeLoggingDBALRepository->savePublished(
            $this->eventCdbid,
            $this->eventPublished
        );

        $storedRow = $this->getStoredRow();

        $this->assertEquals(
            $this->eventPublished,
            new \DateTime($storedRow[SchemaLogConfigurator::PUBLISHED_COLUMN])
        );
    }

    /**
     * @return array
     */
    protected function getStoredRow()
    {
        $sql = 'SELECT * FROM ' . $this->tableName;

        $statement = $this->connection->executeQuery($sql);
        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        return $row;
    }
}
