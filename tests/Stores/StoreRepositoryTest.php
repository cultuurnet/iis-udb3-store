<?php

namespace CultuurNet\UDB3\IISStore\Stores;

use CultuurNet\UDB3\IISStore\Stores\StoreRepository;
use CultuurNet\UDB3\IISStore\Stores\Doctrine\StoreLoggingDBALRepository;

class StoreRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Connection
     */
    private $connection;


    /**
     * @test
     */
    public function test()
    {
       // Implement
    }

//    public function it_loads_an_offer_from_its_correct_repository_based_on_its_type(
//        Url $iri,
//        $id,
//        OfferType $type
//    )
//    {
//        $expectedRepo = new StoreLoggingDBALRepository($connection);
//        // Map the given iri to our expected id and type.
//        $this->iriOfferIdentifierFactory->expects($this->once())
//            ->method('fromIri')
//            ->with($iri)
//            ->willReturn(
//                new IriOfferIdentifier(
//                    $iri,
//                    $id,
//                    $type
//                )
//            );
//    }


    protected function initializeConnection()
    {
        if (!class_exists('PDO')) {
            $this->markTestSkipped('PDO is required to run this test.');
        }

        $availableDrivers = PDO::getAvailableDrivers();
        if (!in_array('sqlite', $availableDrivers)) {
            $this->markTestSkipped(
                'PDO sqlite driver is required to run this test.'
            );
        }

        $this->connection = DriverManager::getConnection(
            [
                'url' => 'sqlite:///:memory:',
            ]
        );
    }

    public function getConnection()
    {
        if (!$this->connection) {
            $this->initializeConnection();
        }

        return $this->connection;
    }
}
