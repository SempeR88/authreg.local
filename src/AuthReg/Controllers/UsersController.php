<?php

namespace AuthReg\Controllers;

use AuthReg\Exceptions\InvalidArgumentException;
use AuthReg\Exceptions\UnauthorizedException;
use AuthReg\Exceptions\NotFoundException;
use AuthReg\Services\UsersAuthService;
use AuthReg\Models\Users\User;

class UsersController extends AbstractController
{
    public function login()
    {
        if (!empty($_POST)) {
	        try {
	            $user = User::login($_POST);
				UsersAuthService::createToken($user);
				header('Location: /');
				exit();
	        } catch (InvalidArgumentException $e) {
	            $this->view->renderHtml('users/login.php', ['error' => $e->getMessage()]);
	            return;
	        }
	    }

	    $this->view->renderHtml('users/login.php');
    }

	public function register()
    {
        if (!empty($_POST)) {
	        try {
	            $user = User::register($_POST);
	        } catch (InvalidArgumentException $e) {
	            $this->view->renderHtml('users/register.php', ['error' => $e->getMessage()]);
	            return;
	        }

			if ($user instanceof User) {
				$this->view->renderHtml('users/registerSuccess.php');
				return;
			}
	    }

	    $this->view->renderHtml('users/register.php');
    }

    public function logout()
    {
        setcookie('token', '', -1, '/', '', false, true);
        header('Location: /');
    }

	public function view(int $userId): void
    {
    	$user = User::getById($userId);

    	if ($user === null) {
	        throw new NotFoundException();
	    }

        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        $this->view->renderHtml('users/view.php', [
            'user' => $user, 
        ]);
    }

	public function edit(int $userId): void
    {
    	$user = User::getById($userId);

    	if ($user === null) {
	        throw new NotFoundException();
	    }

        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!empty($_POST)) {
	        try {
	            $user = User::edit($_POST, $userId);
	        } catch (InvalidArgumentException $e) {
	            $this->view->renderHtml('users/edit.php', ['error' => $e->getMessage()]);
	            return;
	        }

			if ($user instanceof User) {
				$this->view->renderHtml('users/view.php', [
					'user' => $user, 
				]);
				return;
			}
	    }

	    $this->view->renderHtml('users/edit.php', [
            'user' => $user, 
        ]);
    }
}