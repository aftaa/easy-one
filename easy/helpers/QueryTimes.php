<?php

namespace easy\helpers;

use app\config\Config;

class QueryTimes
{
    /** @var QueryTimesItem[] */
    private array $items = [];

    /** @var ?QueryTimesItem */
    private ?QueryTimesItem $item;

    /**
     * @param Config $config
     */
    public function __construct(
        private Config $config,
    )
    { }

    /**
     * @param string $query
     * @param array $params
     * @return void
     */
    public function start(string $query, array $params)
    {
        $this->item = new QueryTimesItem($query, $params);
    }

    /**
     * @return void
     */
    public function stop()
    {
        $this->item->stop($this->config->executionTimePrecision);
        $this->items[] = $this->item;
        $this->item = null;
    }

    /**
     * @return QueryTimesItem[]
     */
    public function get(): array
    {
        return $this->items;
    }
}
