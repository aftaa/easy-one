<?php

namespace easy\basic\router\pocket;

class PocketRouteNamed
{
    public string $name;
    public PocketRoutePreg $preg;

    public function __construct(string $part)
    {
        if (PocketRoutePreg::isPreg($part)) {
            $this->preg = new PocketRoutePreg($part);
            if (preg_match('/^{(.+)</', $part, $matches)) {
                $this->name = $matches[1];
            }
        } else {
            $this->name = str_replace(['{', '}'], '', $part);
        }
    }
}
