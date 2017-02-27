<?php

namespace CultuurNet\UDB3\IISStore\Stores;

use ValueObjects\Identity\UUID;
use ValueObjects\StringLiteral\StringLiteral;

interface XmlRepositoryInterface
{
    /**
     * @param UUID $eventCdbid
     * @param StringLiteral $eventXml
     */
    public function saveEventXml(UUID $eventCdbid, StringLiteral $eventXml);

    /**
     * @param UUID $eventCdbid
     * @param StringLiteral $eventXml
     */
    public function updateEventXml(UUID $eventCdbid, StringLiteral $eventXml);

    /**
     * @param UUID $eventCdbid
     * @return StringLiteral|null
     */
    public function getEventXml(UUID $eventCdbid);
}
