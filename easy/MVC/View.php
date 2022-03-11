<?php

namespace easy\MVC;

use easy\Application;
use easy\basic\Router;

class View
{
    /**
     * //TODO
     * @var string|null Если не null, easy попытается использовать данный шаблон
     */
    public ?string $layout = null;

    /**
     * //TODO
     * Заполняется внутри шаблона для макета
     */
    public array $params = [];

    /**
     * @param string $filename
     * @param array $params
     * @return bool|string
     */
    public function render(string $filename, array  $params = []): bool|string
    {
        try {
            $filename = 'app/views/' . $filename . '.php';
            extract($params);
            ob_start();
            require_once $filename;
            return ob_get_clean();
        } catch (\Throwable $e) {
            ob_clean();
            throw $e;
        } finally {
            ob_clean();
        }
    }

    /**
     * @param string $s
     * @return string
     */
    public function escape(string $s): string
    {
        return htmlspecialchars($s);
    }

    /**
     * @param string $routeName
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public function link(string $name, array $params = []): string
    {
        /** @var Router $router */
        $router = Application::$serviceContainer->get(Router::class);
        return $router->route($name, $params);
    }
}
