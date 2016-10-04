<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 04.10.16
 * Time: 11:43
 */

namespace CultuurNet\UDB3\IISStore\ReadModel\Index;

class StoreRepository implements RepositoryInterface
{

    public function storeEventXml($eventUuid, $eventXml)
    {
        // TODO: Implement storeEventXml() method.
    }

    public function storeRelations($eventUuid, $externalId)
    {
        // TODO: Implement storeRelations() method.
    }

    public function storeStatus($eventUuid, $eventCreated, $eventUpdated, $eventPublished)
    {
        // TODO: Implement storeStatus() method.
    }

    public function getEventCdbid($externalId)
    {
        // TODO: Implement getEventCdbid() method.
    }
}
