<?php

namespace easy\db;

use easy\db\DBAL\NoQueryResult;
use easy\db\DBAL\QueryBuilder;
use easy\db\DBAL\QueryResult;
use easy\db\DBAL\RemoveBuilder;
use easy\db\DBAL\UpgradeBuilder;
use easy\db\helpers\StorageNameToEntityName;
use easy\db\helpers\StorageNameToTableName;
use easy\db\ORM\Entity;
use easy\db\ORM\InsertRecord;
use easy\db\ORM\UpdateRecord;

class Storage
{
    /**
     * @param QueryResult $queryResult
     * @param StorageNameToTableName $storageNameToTableName
     * @param StorageNameToEntityName $storageNameToEntityName
     * @param NoQueryResult $noQueryResult
     * @param InsertRecord $insertRecord
     * @param UpdateRecord $updateRecord
     */
    public function __construct(
        private QueryResult             $queryResult,
        private StorageNameToTableName  $storageNameToTableName,
        private StorageNameToEntityName $storageNameToEntityName,
        private NoQueryResult           $noQueryResult,
        private InsertRecord            $insertRecord,
        private UpdateRecord            $updateRecord,
    )
    {
    }

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

    /**
     * @param int $id
     * @return QueryResult
     */
    public function load(int $id): QueryResult
    {
        return $this->createQueryBuilder()
            ->where('id = :id')
            ->param(':id', $id)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->createRemoveBuilder()
            ->where('id = :id')
            ->param(':id', 'id')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Entity $entity
     * @return int
     * @throws \ReflectionException
     */
    public function store(Entity $entity): int
    {
        $from = $this->storageNameToTableName->transform(get_class($this));
        if (null === $entity->id) {
            return $this->insertRecord->insert($entity, $from);
        } else {
            return $this->updateRecord->update($entity, $from);
        }
    }

    /**
     * @return QueryResult
     */
    public function select(): QueryResult
    {
        return $this->createQueryBuilder()->getQuery()->getResults();
    }
}
