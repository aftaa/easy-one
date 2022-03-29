<?php

namespace easy\MVC;

use easy\Application;
use easy\basic\Router;
use easy\http\Response;

class Controller
{
    final public function __construct(
        private View     $view,
        private Layout   $layout,
        private Response $response,
        private Router   $router,
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
        $this->layout->content = $this->view->render($filename, $params);
        echo $layoutOutput = $this->layout->render($this->view->layout, $this->view->params);
    }

    /**
     * @param string $routeName
     * @param array $params
     * @return never
     * @throws \Exception
     */
    public function redirectToRoute(string $routeName, array $params = []): never
    {
        $href = $this->router->route($routeName, $params);
        $this->redirect($href);
    }

    /**
     * @param string $href
     * @return never
     */
    public function redirect(string $href): never
    {
        header("Location: $href");
        exit;
    }

    /**
     * @return never
     */
    public function back(): never
    {
        if (!empty($_SERVER['HTTP_REFERER'])) {
            $location = $_SERVER['HTTP_REFERER'];
        } else {
            $location = '/';
        }
        header("Location: $location");
        exit;
    }
}
