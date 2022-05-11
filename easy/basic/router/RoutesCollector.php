<?php

namespace easy\basic\router;

use easy\basic\router\pocket\PocketRoute;

class RoutesCollector
{
    /**
     * @param array $files
     * @return CollectedRoutes
     * @throws \ReflectionException
     */
    public function collect(array $files): CollectedRoutes
    {
        $byName = $byPath = [];
        /** @var PocketRoute[] $pocketRouters */
        $pocketRoutes = [];
        $fileNameToClassName = new FilenameToClassname();
        foreach ($files as $file) {
            $class = $fileNameToClassName->transform($file);
            $reflection = new \ReflectionClass($class);

            $pathPrefix = '';
            $attributes = $reflection->getAttributes(Route::class);
            foreach ($attributes as $attribute) {
                $arguments = $attribute->getArguments();
                $path = $arguments[0];
                $pathPrefix = $path;
            }

            foreach ($reflection->getMethods() as $method) {
                $attributes = $method->getAttributes(Route::class);
                foreach ($attributes as $attribute) {
                    $arguments = $attribute->getArguments();
                    $name = @$arguments['name'];
                    $path = $arguments[0];
                    $methods = new RoutingMethods(@$arguments['methods']);
                    if ($pathPrefix) {
                        $path = $pathPrefix . $path;
                    }

                    if (PocketRoute::isPocketRoute($path)) {
                        $pocketRoute = new PocketRoute($path);
                    } else {
                        $pocketRoute = null;
                    }

                    $routing = new Routing($class, $method->name, $name, $path, $pocketRoute, $methods);
                    if ($name) {
                        $byName[$name] = $routing;
                    }

                    if ($path instanceof PocketRoute) {
                        $pocketRoutes[] = $path;
                    } else {
                        $byPath[$path] = $routing;
                    }
                }
            }
        }
        return new CollectedRoutes($byName, $byPath, $pocketRoutes);
    }
}
