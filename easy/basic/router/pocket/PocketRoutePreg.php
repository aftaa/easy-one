<?php

namespace easy\basic\router\pocket;

class PocketRoutePreg
{
    private const DELIMITER = '<';
    public string $preg;

    /**
     * @param string $part
     * @return bool
     */
    public static function isPreg(string $part): bool
    {
        return str_contains($part, self::DELIMITER);
    }

    /**
     * @param string $part
     */
    public function __construct(string $part)
    {
        $this->preg = $this->parse($part);
    }

    private function parse(string $part): string
    {
        if (preg_match('/<(.+?)>/', $part, $matches)) {
            return $matches[1];
        }
    }
}
