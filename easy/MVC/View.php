<?php

namespace easy\MVC;

use easy\Application;
use easy\basic\Router;

class View
{
    use ViewLayoutTrait;

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
}
