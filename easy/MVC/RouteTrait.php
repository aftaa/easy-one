<?php

namespace easy\MVC;

use easy\Application;
use easy\basic\Router;

trait RouteTrait
{
    /**
     * @param string $name
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public function href(string $name, array $params = []): string
    {
        /** @var Router $router */
        $router = Application::$serviceContainer->get(Router::class);
        return $router->route($name, $params);
    }

    /**
     * @param string $name
     * @param array $params
     * @param string $label
     * @return string
     * @throws \Exception
     */
    public function link(string $name, array $params, string $label): string
    {
        $href = $this->href($name, $params);
        $html = "<a href=\"$href\">$label</a>";
        return $html;
    }
}
