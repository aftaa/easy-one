<?php

namespace easy\db;

use easy\db\DBAL\QueryBuilder;
use easy\db\DBAL\QueryResult;
use easy\db\helpers\StorageNameToEntityName;
use easy\db\helpers\StorageNameToTableName;
use JetBrains\PhpStorm\Pure;

class Storage
{
    /**
     * @param QueryResult $queryResult
     * @param StorageNameToTableName $storageNameToTableName
     * @param StorageNameToEntityName $storageNameToEntityName
     */
    public function __construct(
        private QueryResult $queryResult,
        private StorageNameToTableName $storageNameToTableName,
        private StorageNameToEntityName $storageNameToEntityName,
    )
    { }

    /**
     * @return QueryBuilder
     */
    protected function createQueryBuilder(): QueryBuilder
    {
        $storageName = get_class($this);
        $from = $this->storageNameToTableName->transform($storageName);
        $entity = $this->storageNameToEntityName->transform($storageName);
        return (new QueryBuilder($this->queryResult))->from($from)->entity($entity);
    }
}