<?php

namespace easy\MVC;

use easy\Application;

class Controller
{
    final public function __construct(
        private View $view,
        private Layout $layout,
    )
    {

    }

    /**
     * @throws \Throwable
     */
    public function render(string $filename, $params = [])
    {
        $viewOutput = $this->view->render($filename, $params);

        /** @var Layout $layout */
//        $layout = Application::$serviceContainer->init(Layout::class);
        $this->layout->content = $viewOutput;
        $layoutOutput = $this->layout->render($this->view->layout, $this->view->params);
        echo $layoutOutput;
    }

    public function setView()
    {

    }
}
