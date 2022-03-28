<?php

spl_autoload_register(/**
 * @throws Exception
 */ function (string $classname) {
    $filename = str_replace('\\', '/', $classname);
    $filename .= '.php';
    if (!file_exists($filename)) {
        header('HTTP/1.0 404 Not Found');
        throw new Exception("require_once error: filename $filename for classname $classname not found");
    }
    require_once $filename;
});

//(new \easy\Application(
//    \easy\basic\startup\DebugMode::true,
//    \easy\basic\startup\Environment::DEV))->run();

$serviceContainer = new \easy\basic\ServiceContainer();
$dependencyInjection = new \easy\basic\DependencyInjection(new \app\config\basic\dependencyInjection\Config(), $serviceContainer);
$serviceContainer->add($dependencyInjection);
/** @var \easy\basic\Router $router */
$router = $serviceContainer->init(\easy\basic\Router::class);
$router->cli_debug();
