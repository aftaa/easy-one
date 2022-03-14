<?php

namespace easy\MVC;

use easy\Application;
use easy\http\Response;

class Controller
{
    final public function __construct(
        private View $view,
        private Layout $layout,
        private Response $response,
    )
    {

    }

    /**
     * @param string $filename
     * @param $params
     * @return void
     * @throws \Throwable
     */
    public function render(string $filename, $params = [])
    {
        $viewOutput = $this->view->render($filename, $params);
        $this->layout->content = $viewOutput;
        $layoutOutput = $this->layout->render($this->view->layout, $this->view->params);
        echo $layoutOutput;
    }
}
