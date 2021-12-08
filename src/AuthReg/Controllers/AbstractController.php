<?php

namespace AuthReg\Controllers;

use AuthReg\Services\UsersAuthService;
use AuthReg\View\View;

class AbstractController
{
	protected $view;
	protected $user;

	public function __construct()
	{
		$this->user = UsersAuthService::getUserByToken();
		$this->view = new View(__DIR__ . '/../../../templates');
		$this->view->setVar('user', $this->user);
	}
}