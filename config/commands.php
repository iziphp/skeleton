<?php

use Doctrine\DBAL\Tools\Console\Command\RunSqlCommand;
use Doctrine\ORM\Tools\Console\Command as ORMCommand;

return [

    // Doctrine DBAL Commands
    'dbal:run-sql' => RunSqlCommand::class,

    // Doctrine ORM Commands
    'orm:clear-cache:region:collection' => ORMCommand\ClearCache\CollectionRegionCommand::class,
    'orm:clear-cache:region:entity' => ORMCommand\ClearCache\EntityRegionCommand::class,
    'orm:clear-cache:metadata' => ORMCommand\ClearCache\MetadataCommand::class,
    'orm:clear-cache:query' => ORMCommand\ClearCache\QueryCommand::class,
    'orm:clear-cache:region:query' => ORMCommand\ClearCache\QueryRegionCommand::class,
    'orm:clear-cache:result' => ORMCommand\ClearCache\ResultCommand::class,
    'orm:schema-tool:create' => ORMCommand\SchemaTool\CreateCommand::class,
    'orm:schema-tool:update' => ORMCommand\SchemaTool\UpdateCommand::class,
    'orm:schema-tool:drop' => ORMCommand\SchemaTool\DropCommand::class,
    'orm:generate-proxies' => ORMCommand\GenerateProxiesCommand::class,
    'orm:run-dql' => ORMCommand\RunDqlCommand::class,
    'orm:validate-schema' => ORMCommand\ValidateSchemaCommand::class,
    'orm:info' => ORMCommand\InfoCommand::class,
    'orm:mapping:describe' => ORMCommand\MappingDescribeCommand::class,
];
