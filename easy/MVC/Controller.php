<?php

namespace easy\MVC;

use easy\Application;

class Controller
{
    /**
     * @throws \Throwable
     */
    public function render(string $filename, $params = [])
    {
        $view = new View();
        $viewOutput = $view->render($filename, $params);

        /** @var Layout $layout */
        $layout = Application::$serviceContainer->init(Layout::class);
        $layout->content = $viewOutput;
        $layoutOutput = $layout->render($view->layout, $view->params);
        echo $layoutOutput;
    }
}
