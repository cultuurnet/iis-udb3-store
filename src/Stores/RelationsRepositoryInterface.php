<?php

namespace CultuurNet\UDB3\IISStore\Stores;

use ValueObjects\Identity\UUID;
use ValueObjects\StringLiteral\StringLiteral;

interface RelationsRepositoryInterface
{
    /**
     * @param UUID $eventUuid
     * @param StringLiteral $externalId
     * @param bool $isUpdate
     */
    public function storeRelations(UUID $eventUuid, StringLiteral $externalId, $isUpdate);


    /**
     * @param StringLiteral $externalId
     * @return UUID|null $cdbid
     */
    public function getEventCdbid(StringLiteral $externalId);
}
