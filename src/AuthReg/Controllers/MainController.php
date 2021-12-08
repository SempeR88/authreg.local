<?php

namespace AuthReg\Controllers;

use AuthReg\Services\UsersAuthService;

class MainController extends AbstractController
{
	public function main()
    {
        $this->view->renderHtml('main/main.php', [
            'user' => UsersAuthService::getUserByToken()
        ]);
    }
}