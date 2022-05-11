<?php

namespace easy\basic\router;

use easy\basic\router\pocket\PocketRoute;

class Routing
{
    public function __construct(
        public string $controller,
        public string $action,
        public ?string $name = null,
        public ?string $path = null,
        public ?PocketRoute $pocketRoute = null,
        public ?RoutingMethods $methods = null,
    )
    { }
}
