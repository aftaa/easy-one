<?php

namespace easy\db\DBAL;

use easy\db\Connection;
use easy\db\ORM\ArrayToEntity;
use easy\db\ORM\Entity;
use easy\helpers\QueryTimes;

class QueryResult
{
    private string $query;
    private string $entity;
    private array $params;
    private array $data;

    /**
     * @param Connection $connection
     * @param ArrayToEntity $arrayToEntity
     * @param QueryTimes $queryTimes
     */
    public function __construct(
        private Connection $connection,
        private ArrayToEntity $arrayToEntity,
        private QueryTimes $queryTimes,
    )
    { }

    /**
     * @param string $query
     * @return $this
     */
    public function query(string $query): static
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @param string $entity
     * @return $this
     */
    public function entity(string $entity): static
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function params(array $params): static
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return $this|null
     */
    public function getResult(): ?static
    {
        $this->queryTimes->start($this->query, $this->params);
        $stmt = $this->connection->get()->prepare($this->query);
        $stmt->execute($this->params);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        $this->queryTimes->stop();
        if (false === $data) {
            return null;
        } else {
            $this->data = $data;
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function getResults(): static
    {
        $this->queryTimes->start($this->query, $this->params);
        $stmt = $this->connection->get()->prepare($this->query);
        $stmt->execute($this->params);
        $this->data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $this->queryTimes->stop();
        return $this;
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        return $this->data;
    }

    /**
     * @return Entity[]
     * @throws \Exception
     */
    public function asEntities(): array
    {
        $entities = [];
        foreach ($this->data as $row) {
            $entities[] = $this->arrayToEntity->transform($this->entity, $row);
        }
        return $entities;
    }

    /**
     * @return Entity
     * @throws \Exception
     */
    public function asEntity(): Entity
    {
        return $this->arrayToEntity->transform($this->entity, $this->result);
    }
}
