<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use CultuurNet\UDB3\IISStore\Doctrine\DBAL\SchemaConfiguratorInterface;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Types\Type;
use ValueObjects\StringLiteral\StringLiteral;

class SchemaLogConfigurator implements SchemaConfiguratorInterface
{
    const UUID_COLUMN = 'cdbid';
    const CREATE_COLUMN = 'created';
    const UPDATED_COLUMN = 'updated';
    const PUBLISHED_COLUMN = 'published';
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

        $table->addColumn(self::UUID_COLUMN, Type::GUID)
            ->setLength(36)
            ->setNotnull(true);
        $table->addColumn(self::CREATE_COLUMN, Type::DATETIME)
            ->setNotnull(false);
        $table->addColumn(self::UPDATED_COLUMN, Type::DATETIME)
            ->setNotnull(false);
        $table->addColumn(self::PUBLISHED_COLUMN, Type::DATETIME)
            ->setNotnull(false);

        $table->addIndex([self::UUID_COLUMN]);

        $schemaManager->createTable($table);
    }
}
