<?php

namespace easy;

use app\config\Config;
use app\controllers\ErrorController;
use easy\basic\DependencyInjection;
use easy\basic\Router;
use easy\basic\router\Routing;
use easy\basic\ServiceContainer;
use easy\basic\startup\DebugMode;
use easy\basic\startup\Environment;
use easy\helpers\TimeExecution;
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
        // TODO
        if (null === $routing) {

            $router->debug();
            throw new \Exception("---404--- The route for $_SERVER[REQUEST_URI] not found");
        }
        try {
            $this->main($dependencyInjection, $routing);
        } catch (\Throwable $e) {
            /** @var ErrorController $view */
            $view = self::$serviceContainer->init(ErrorController::class);
            $view->exception = $e;
            echo $view->httpInternalServerError();
        }
//        $router = new HtmlDebug();
//        $router->debug();
//        echo self::$serviceContainer->get(TimeExecution::class)->stop();
//        $qt = self::$serviceContainer->get(QueryTimesDebug::class)->get();
//        var_dump($qt);
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
