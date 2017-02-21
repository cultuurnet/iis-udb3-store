<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\Doctrine\DBAL\SchemaConfiguratorInterface;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Types\Type;
use ValueObjects\StringLiteral\StringLiteral;

class SchemaRelationConfigurator implements SchemaConfiguratorInterface
{
    const CDBID_COLUMN = 'cdbid';
    const EXTERNAL_ID_COLUMN = 'external_id';

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
        $table->addColumn(self::EXTERNAL_ID_COLUMN, Type::TEXT)
            ->setNotnull(true);

        $table->addUniqueIndex([self::CDBID_COLUMN]);
        $table->addUniqueIndex([self::EXTERNAL_ID_COLUMN]);

        $schemaManager->createTable($table);
    }
}
