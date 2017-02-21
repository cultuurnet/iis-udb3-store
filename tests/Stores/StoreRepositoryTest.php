<?php

namespace CultuurNet\UDB3\IISStore\Stores;

use ValueObjects\Identity\UUID;
use ValueObjects\StringLiteral\StringLiteral;

class StoreRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LoggingRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $loggingRepository;

    /**
     * @var RelationRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $relationRepository;

    /**
     * @var XmlRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $xmlRepository;

    /**
     * @var StoreRepository
     */
    private $storeRepository;

    protected function setUp()
    {
        $this->loggingRepository = $this->createMock(LoggingRepositoryInterface::class);

        $this->relationRepository = $this->createMock(RelationRepositoryInterface::class);

        $this->xmlRepository = $this->createMock(XmlRepositoryInterface::class);

        $this->storeRepository = new StoreRepository(
            $this->loggingRepository,
            $this->relationRepository,
            $this->xmlRepository
        );
    }

    /**
     * @test
     */
    public function it_delegates_get_event_cdbid_to_relation_repository()
    {
        $eventCdbid = new UUID();
        $externalId = new StringLiteral('CDB:Example123');

        $this->relationRepository->expects($this->once())
            ->method('getEventCdbid')
            ->with($externalId)
            ->willReturn($eventCdbid);

        $actualEventCdbid = $this->storeRepository->getEventCdbid($externalId);

        $this->assertEquals($eventCdbid, $actualEventCdbid);
    }

    /**
     * @test
     */
    public function it_delegates_save_relation_to_relation_repository()
    {
        $eventCdbid = new UUID();
        $externalId = new StringLiteral('CDB:Example123');

        $this->relationRepository->expects($this->once())
            ->method('saveRelation')
            ->with($eventCdbid, $externalId);

        $this->storeRepository->saveRelation($eventCdbid, $externalId);
    }

    /**
     * @test
     */
    public function it_delegates_save_event_xml_to_xml_repository()
    {
        $eventCdbid = new UUID();
        $eventXml = new StringLiteral('<xml></xml>');

        $this->xmlRepository->expects($this->once())
            ->method('saveEventXml')
            ->with($eventCdbid, $eventXml);

        $this->storeRepository->saveEventXml($eventCdbid, $eventXml);
    }

    /**
     * @test
     */
    public function it_delegates_update_event_xml_to_xml_repository()
    {
        $eventCdbid = new UUID();
        $eventXml = new StringLiteral('<xml></xml>');

        $this->xmlRepository->expects($this->once())
            ->method('updateEventXml')
            ->with($eventCdbid, $eventXml);

        $this->storeRepository->updateEventXml($eventCdbid, $eventXml);
    }

    /**
     * @test
     */
    public function it_delegates_get_event_xml_to_xml_repository()
    {
        $eventCdbid = new UUID();
        $eventXml = new StringLiteral('<xml></xml>');

        $this->xmlRepository->expects($this->once())
            ->method('getEventXml')
            ->with($eventCdbid)
            ->willReturn($eventXml);

        $actualEventXml = $this->storeRepository->getEventXml($eventCdbid);

        $this->assertEquals($eventXml, $actualEventXml);
    }
}
