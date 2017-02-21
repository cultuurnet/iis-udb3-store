<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\Doctrine\DBAL\SchemaConfiguratorInterface;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Types\Type;
use ValueObjects\StringLiteral\StringLiteral;

class SchemaXmlConfigurator implements SchemaConfiguratorInterface
{
    const CDBID_COLUMN = 'cdbid';
    const XML_COLUMN = 'cdbxml';

    /**
     * @var StringLiteral
     */
    protected $tableName;

    /**
     * @param StringLiteral $tableName
     */
    public function __construct(StringLiteral $tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @inheritdoc
     */
    public function configure(AbstractSchemaManager $schemaManager)
    {
        $schema = $schemaManager->createSchema();
        $table = $schema->createTable($this->tableName->toNative());

        $table->addColumn(self::CDBID_COLUMN, Type::GUID)
            ->setLength(36)
            ->setNotnull(true);
        $table->addColumn(self::XML_COLUMN, Type::TEXT)
            ->setNotnull(true);

        $table->setPrimaryKey([self::CDBID_COLUMN]);
        $table->addUniqueIndex([self::CDBID_COLUMN]);

        $schemaManager->createTable($table);
    }
}
