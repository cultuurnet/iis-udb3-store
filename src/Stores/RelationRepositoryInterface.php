<?php

namespace CultuurNet\UDB3\IISStore\Stores;

use ValueObjects\Identity\UUID;
use ValueObjects\StringLiteral\StringLiteral;

interface RelationRepositoryInterface
{
    /**
     * @param UUID $eventCdbid
     * @param StringLiteral $externalId
     */
    public function saveRelation(UUID $eventCdbid, StringLiteral $externalId);


    /**
     * @param StringLiteral $externalId
     * @return UUID|null $cdbid
     */
    public function getEventCdbid(StringLiteral $externalId);
}
