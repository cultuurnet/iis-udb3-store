<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\DBALTestConnectionTrait;
use ValueObjects\DateTime\Date;
use ValueObjects\DateTime\DateTime;
use ValueObjects\DateTime\Month;
use ValueObjects\DateTime\MonthDay;
use ValueObjects\DateTime\Year;
use ValueObjects\Identity\UUID;
use \ValueObjects\String\String as StringLiteral;

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
    private $cdbid;

    /**
     * @var DateTime
     */
    private $eventCreated;

    /**
     * @var DateTime
     */
    private $eventUpdated;

    /**
     * @var DateTime
     */
    private $eventPublished;

    /**
     * @var StoreLoggingDBALRepository
     */
    private $storeLoggingDBALRepository;

    /**
     * @param int $yearsToSubtract
     * @return Date
     */
    private function getPreviousDate($yearsToSubtract)
    {
        $year = new Year(2016 - $yearsToSubtract);
        $month = Month::now();
        $monthDay = new MonthDay(6);
        return new Date($year, $month, $monthDay);
    }

    protected function setUp()
    {
        $this->tableName = new StringLiteral('test_logging');

        $schemaConfigurator = new SchemaLogConfigurator($this->tableName);
        $schemaManager = $this->getConnection()->getSchemaManager();
        $schemaConfigurator->configure($schemaManager);

        $this->cdbid = new UUID();

        $this->eventCreated = new DateTime($this->getPreviousDate(3));
        $this->eventUpdated = new DateTime($this->getPreviousDate(2));
        $this->eventPublished = new DateTime($this->getPreviousDate(1));

        $this->storeLoggingDBALRepository = new StoreLoggingDBALRepository(
            $this->getConnection(),
            $this->tableName
        );
    }

    /**
     * @test
     */
    public function it_stores_a_status()
    {
//        $this->storeLoggingDBALRepository->storeStatus(
//            $this->cdbid,
//            $this->eventCreated,
//            $this->eventUpdated,
//            $this->eventPublished
//        );

        //$storedStatus = $this->getStoredStatus();
    }

    /**
     * @return mixed
     */
    protected function getStoredStatus()
    {
        $sql = 'SELECT * FROM ' . $this->tableName;

        $statement = $this->connection->executeQuery($sql);
        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        return $row[1];
    }
}
