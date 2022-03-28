<?php

namespace easy\MVC;

use app\config\MVC\Layout\Config;
use easy\Application;
use easy\basic\Router;

class Layout
{
    use ViewLayoutTrait;

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

    /**
     * @param string|null $filename
     * @param array|null $params
     * @return false|string
     */
    public function render(?string $filename = null, ?array $params = [])
    {
//        try {

            if (null === $filename) {
                $filename = $this->config->defaultLayout;
            }
            $filename = 'app/layouts/' . $filename . '.php';
            if (!file_exists($filename)) {
                throw new \LogicException("Layout file $filename not found.");
            }
            extract($params);
//            ob_start();
            require_once $filename;
//            return ob_get_clean();
//        } catch (\Throwable $e) {
//            ob_clean();
//            throw $e;
//        } finally {
//            ob_clean();
//        }
    }
}
