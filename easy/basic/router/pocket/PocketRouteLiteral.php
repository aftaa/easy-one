<?php

namespace easy\basic\router\pocket;

class PocketRouteLiteral
{
    public string $part;

    /**
     * @param string $part
     */
    public function __construct(string $part)
    {
        $this->part = $part;
    }
}
