<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\Stores\RelationsRepositoryInterface;
use ValueObjects\Identity\UUID;
use ValueObjects\String\String as StringLiteral;

class StoreRelationsDBALRepository extends AbstractDBALRepository implements RelationsRepositoryInterface
{
    /**
     * @param UUID $eventUuid
     * @param StringLiteral $externalId
     */
    public function storeRelations(UUID $eventUuid, StringLiteral $externalId)
    {
        // TODO: Implement storeRelations() method.
    }
}
