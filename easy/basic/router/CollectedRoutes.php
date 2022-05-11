<?php

namespace easy\basic\router;

class CollectedRoutes
{
    public function __construct(
        public array $routesByName,
        public array $routesByPath,
        /** PocketRouter[] */
        public array $pocketRoutes,
    )
    { }
}
