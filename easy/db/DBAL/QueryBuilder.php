<?php

namespace easy\db\DBAL;

class QueryBuilder
{
    private string $select = '*';
    private string $from;
    private ?string $where = null;
    private ?string $groupBy = null;
    private ?string $having = null;
    private array $orderBy = [];
    private ?int $limit = null;
    private ?int $offset = null;
    private array $params = [];
    private ?string $join = '';
    private string $entity;

    public function __construct(
        private QueryResult $queryResult,
    )
    {
    }

    /**
     * @param string $select
     * @return $this
     */
    public function select(string $select): static
    {
        $this->select = $select;
        return $this;
    }

    /**
     * @param string $from
     * @return $this
     */
    public function from(string $from): static
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @param string $where
     * @return $this
     */
    public function where(string $where): static
    {
        $this->where = $where;
        return $this;
    }

    /**
     * @param string $andWhere
     * @return $this
     */
    public function andWhere(string $andWhere): static
    {
        $this->where .= ' AND ' . $andWhere . ' ';
        return $this;
    }

    /**
     * @param string $groupBy
     * @return $this
     */
    public function groupBy(string $groupBy): static
    {
        $this->groupBy = $groupBy;
        return $this;
    }

    /**
     * @param string $having
     * @return $this
     */
    public function having(string $having): static
    {
        $this->having = $having;
        return $this;
    }

    /**
     * @param array $orderBy
     * @return $this
     */
    public function orderBy(array $orderBy): static
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit): static
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset(int $offset): static
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * @param string $join
     * @return $this
     */
    public function join(string $join): static
    {
        $this->join = $join;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function param(string $name, mixed $value): static
    {
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * @return QueryResult
     */
    public function getQuery(): QueryResult
    {
        $query[] = 'SELECT ' . $this->select . ' FROM ' . $this->from;
        if ($this->where) {
            $query[] = 'WHERE ' . $this->where;
        }
        if ($this->groupBy) {
            $query[] = ' GROUP BY ' . $this->groupBy;
        }
        if ($this->orderBy) {
            $query[] = 'ORDER BY ' . $this->orderBy[0];
            $query[] = match ($this->orderBy[1]) {
                SORT_DESC => ' DESC ',
                default => ' ASC ',
            };
        }
        if ($this->limit) {
            $query[] = 'LIMIT ' . $this->limit;
        }
        if ($this->offset) {
            $query[] = 'OFFSET ' . $this->offset;
        }
        $query = implode(' ', $query);
        return $this->queryResult->entity($this->entity)->query($query)->params($this->params);
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
}
