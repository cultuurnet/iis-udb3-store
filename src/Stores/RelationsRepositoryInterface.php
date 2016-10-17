<?php

namespace CultuurNet\UDB3\IISStore\Stores;

use ValueObjects\Identity\UUID;
use ValueObjects\String\String as StringLiteral;

interface RelationsRepositoryInterface
{
    /**
     * @param UUID $eventUuid
     * @param StringLiteral $externalId
     */
    public function storeRelations(UUID $eventUuid, StringLiteral $externalId);
}
