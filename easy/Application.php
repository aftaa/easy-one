<?php

namespace easy;

use app\config\Config;
use easy\basic\DependencyInjection;
use easy\basic\Router;
use easy\basic\router\Routing;
use easy\basic\ServiceContainer;
use easy\basic\startup\DebugMode;
use easy\basic\startup\Environment;
use easy\helpers\TimeExecution;
use easy\MVC\Layout;
use easy\MVC\View;

final class Application
{
    public static DebugMode $debugMode;
    public static Environment $environment;
    public static Config $config;
    public static ServiceContainer $serviceContainer;

    /**
     * @param DebugMode $debugMode
     * @param Environment $environment
     */
    public function __construct(DebugMode $debugMode, Environment $environment)
    {
        self::$debugMode = $debugMode;
        self::$environment = $environment;
        self::$config = new Config();
        self::$serviceContainer = new ServiceContainer();
        self::$serviceContainer->add(new TimeExecution(self::$config));
    }

    /**
     * @return never
     * @throws \ReflectionException
     */
    public function run(): never
    {
        $dependencyInjection = new DependencyInjection(new \app\config\basic\dependencyInjection\Config(), self::$serviceContainer);
        self::$serviceContainer->add($dependencyInjection);
        /** @var Router $router */
        $router = $dependencyInjection->make(Router::class);
        $routing = $router->findControllerActionByRequestUri();
        try {
            // TODO
            if (null === $routing) {

                $router->debug();
                throw new \Exception("---404--- The route for $_SERVER[REQUEST_URI] not found");
            }
            $this->main($dependencyInjection, $routing);
        } catch (\Throwable $e) {
            $view = self::$serviceContainer->init(View::class);
            $errorView = $view->render('errors/500');
            /** @var Layout $layout */
            $layout = self::$serviceContainer->init(Layout::class);
            $layout->content = $errorView;
            $errorView = $layout->render('error');
            echo $errorView;
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
        exit;
    }

    /**
     * @throws \ReflectionException
     */
    public function main(DependencyInjection $dependencyInjection, Routing $routing)
    {
        $controller = $dependencyInjection->make($routing->controller);
        $reflection = new \ReflectionObject($controller);
        $method = $reflection->getMethod($routing->action);
        $parameters = $method->getParameters();
        $arguments = [];
        foreach ($parameters as $parameter) {
            $typename = $parameter->getType()->getName();
            $arguments[] = $dependencyInjection->make($typename);
        }
        $controller->{$routing->action}(...$arguments);
    }
}
