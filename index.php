<?php

try {
	spl_autoload_register(function (string $className) {
		require_once __DIR__ . '/src/' . str_replace('\\', '/', $className) . '.php';
	});

	$route = $_GET['route'] ?? ''; 
	$routes = require_once __DIR__ . '/src/routes.php';

	$isRouteFound = false;
	foreach ($routes as $pattern => $controllerAndAction) {
		preg_match($pattern, $route, $matches);
		if (!empty($matches)) {
			$isRouteFound = true;
			break;
		}
	}

	if (!$isRouteFound) {
	    throw new \AuthReg\Exceptions\NotFoundException();
	}

	unset($matches[0]);

	$controllerName = $controllerAndAction[0];
	$actionName = $controllerAndAction[1];

	$controller = new $controllerName();
	$controller->$actionName(...$matches);
} catch (\AuthReg\Exceptions\DbException $e) {
    $view = new \AuthReg\View\View(__DIR__ . '/templates/errors');
    $view->renderHtml('500.php', ['error' => $e->getMessage()], 500);
} catch (\AuthReg\Exceptions\NotFoundException $e) {
    $view = new \AuthReg\View\View(__DIR__ . '/templates/errors');
    $view->renderHtml('404.php', ['error' => $e->getMessage()], 404);
} catch (\AuthReg\Exceptions\UnauthorizedException $e) {
    $view = new \AuthReg\View\View(__DIR__ . '/templates/errors');
    $view->renderHtml('401.php', ['error' => $e->getMessage()], 401);
}