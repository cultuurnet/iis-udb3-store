<?php

namespace CultuurNet\UDB3\IISStore\ReadModel\Index;

use ValueObjects\Identity\UUID;
use ValueObjects\String\String as StringLiteral;

interface XmlRepositoryInterface
{
    /**
     * @param StringLiteral $eventUuid
     * @param StringLiteral $eventXml
     * @param bool $isUpdate
     */
    public function storeEventXml($eventUuid, $eventXml, $isUpdate);

    /**
     * @param StringLiteral $externalId
     * @return UUID|null $cdbid
     */
    public function getEventCdbid($externalId);
}
