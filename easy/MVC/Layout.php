<?php

namespace easy\MVC;

use app\config\MVC\Layout\Config;

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
}
