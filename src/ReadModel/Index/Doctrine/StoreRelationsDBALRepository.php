<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 04.10.16
 * Time: 11:43
 */

namespace CultuurNet\UDB3\IISStore\ReadModel\Index;

use ValueObjects\DateTime\DateTime;
use ValueObjects\Identity\UUID;

class StoreRelationsDBALRepository extends AbstractDBALRepository implements RelationsRepositoryInterface
{
    /**
     * @param string $eventUuid
     * @param string $externalId
     */
    public function storeRelations($eventUuid, $externalId)
    {
        // TODO: Implement storeRelations() method.
    }
}
