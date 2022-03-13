<?php

namespace easy\MVC;

use app\config\MVC\Layout\Config;
use easy\Application;
use easy\basic\Router;

class Layout
{
    /**
     * @var string
     */
    public string $content;

    /**
     * @param Config $config
     */
    public function __construct(
        private Config $config,
    )
    {
    }

    public function render(?string $filename, array $params = [])
    {
        try {
            if (null === $filename) {
                $filename = $this->config->defaultLayout;
            }
            $filename = 'app/layouts/' . $filename . '.php';
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
