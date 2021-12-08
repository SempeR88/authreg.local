<?php

return [
	'~^$~' => [\AuthReg\Controllers\MainController::class, 'main'],
	'~^users/login$~' => [\AuthReg\Controllers\UsersController::class, 'login'],
	'~^users/register$~' => [\AuthReg\Controllers\UsersController::class, 'register'],
	'~^users/logout~' => [\AuthReg\Controllers\UsersController::class, 'logout'],
	'~^users/(\d+)/view$~' => [\AuthReg\Controllers\UsersController::class, 'view'],
	'~^users/(\d+)/edit$~' => [\AuthReg\Controllers\UsersController::class, 'edit'],
];