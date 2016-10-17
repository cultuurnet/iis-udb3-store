<?php

namespace CultuurNet\UDB3\IISStore\Stores\Doctrine;

use \ValueObjects\String\String as StringLiteral;

class StoreLoggingDBALRepositoryTest extends AbstractBaseDBALRepositoryTest
{
    protected function setUp()
    {
        $this->tableName = new StringLiteral('test_logging');
        $schemaConfigurator = new SchemaLogConfigurator($this->tableName);
        $schemaManager = $this->getConnection()->getSchemaManager();
        $schemaConfigurator->configure($schemaManager);

        parent::setUp();
    }

    /**
     * @test
     */
    public function it_should_store_a_status()
    {
    }
}
