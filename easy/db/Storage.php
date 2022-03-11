<?php

namespace easy\db;

use easy\db\DBAL\NoQueryResult;
use easy\db\DBAL\QueryBuilder;
use easy\db\DBAL\QueryResult;
use easy\db\DBAL\RemoveBuilder;
use easy\db\DBAL\UpgradeBuilder;
use easy\db\helpers\StorageNameToEntityName;
use easy\db\helpers\StorageNameToTableName;

class Storage
{
    /**
     * @param QueryResult $queryResult
     * @param StorageNameToTableName $storageNameToTableName
     * @param StorageNameToEntityName $storageNameToEntityName
     * @param NoQueryResult $noQueryResult
     */
    public function __construct(
        private QueryResult             $queryResult,
        private StorageNameToTableName  $storageNameToTableName,
        private StorageNameToEntityName $storageNameToEntityName,
        private NoQueryResult           $noQueryResult,
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

    /**
     * @return UpgradeBuilder
     */
    public function createUpgradeBuilder(): UpgradeBuilder
    {
        $storageName = get_class($this);
        $from = $this->storageNameToTableName->transform($storageName);
        return (new UpgradeBuilder($this->noQueryResult))->from($from);
    }

    /**
     * @return RemoveBuilder
     */
    public function createRemoveBuilder(): RemoveBuilder
    {
        $storageName = get_class($this);
        $from = $this->storageNameToTableName->transform($storageName);
        return (new RemoveBuilder($this->noQueryResult))->from($from);
    }
}
