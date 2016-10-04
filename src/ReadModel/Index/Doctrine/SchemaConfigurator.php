<?php

namespace CultuurNet\UDB3\IISStore\Event\ReadModel\Index;

use CultuurNet\UDB3\IISStore\Doctrine\DBAL\SchemaConfiguratorInterface;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use ValueObjects\String\String as StringLiteral;

class SchemaConfigurator implements SchemaConfiguratorInterface
{
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

        $table->addColumn(
            'entity_id',
            'uuid',
            array('length' => 36, 'notnull' => true)
        );
        $table->addColumn(
            'entity_xml',
            'text'
        );

        $schemaManager->createTable($table);
    }
}
