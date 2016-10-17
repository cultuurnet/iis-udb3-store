<?php

namespace CultuurNet\UDB3\IISStore\Stores;

use ValueObjects\Identity\UUID;
use ValueObjects\String\String as StringLiteral;

interface XmlRepositoryInterface
{
    /**
     * @param UUID $eventUuid
     * @param StringLiteral $eventXml
     * @param bool $isUpdate
     */
    public function storeEventXml(UUID $eventUuid, StringLiteral $eventXml, $isUpdate);
}
