<?php

namespace easy\mvc;

use app\entities\User;
use easy\auth\Authenticate;
use easy\helpers\RememberMeStatus;
use easy\http\Session;
use easy\auth\RememberMe;
use easy\basic\Router;

class Controller
{
    /**
     * @throws \Exception
     */
    final public function __construct(
        private readonly View $view,
        private readonly Layout $layout,
        private readonly Router $router,
        private readonly RememberMe $rememberMe,
        private readonly Session $session,
        private readonly RememberMeStatus $rememberMeStatus,
    )
    {
        $authenticated = $this->rememberMe->authenticate();
        $this->rememberMeStatus->setStatus($authenticated);
    }

    /**
     * @param string $filename
     * @param array $params
     * @return void
     */
    public function render(string $filename, array $params = []): void
    {
        $this->layout->content = $this->view->render($filename, $params);
        echo $this->layout->render($this->view->layout, $this->view->params);
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
        $this->redirect($location);
    }

    /**
     * @return User|null
     */
    public function user(): ?User
    {
        if ($this->session->has(Authenticate::class)) {
            return $this->session->get(Authenticate::class);
        }
        return null;
    }
}
