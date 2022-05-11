<?php

namespace easy\basic\router\pocket;

class PocketRoute
{
    private const DELIMITER = '{';
    public array $pockets = [];

    /**
     * @param string $path
     * @return bool
     */
    public static function isPocketRoute(string $path): bool
    {
        return str_contains($path, self::DELIMITER);
    }

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->parse($path);
    }

    /**
     * @param PocketRouteLiteral|PocketRouteNamed $pocket
     * @return void
     */
    private function add(PocketRouteLiteral|PocketRouteNamed $pocket): void
    {
        $this->pockets[] = $pocket;
    }

    /**
     * @param string $path
     * @return void
     */
    private function parse(string $path): void
    {
        preg_replace_callback('/([^{]+)|({.+?})/', function (array $matches) use ($path) {
            if (PocketRoute::isPocketRoute($path)) {
                $pocket = new PocketRouteNamed($path);
            } else {
                $pocket = new PocketRouteLiteral($path);
            }
            $this->add($pocket);
        }, $path);
    }
}
