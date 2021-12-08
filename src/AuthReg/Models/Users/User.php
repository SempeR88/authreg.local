<?php

namespace AuthReg\Models\Users;

use AuthReg\Exceptions\InvalidArgumentException;
use AuthReg\Models\ActiveRecordEntity;
use AuthReg\Services\Db;

class User extends ActiveRecordEntity
{
	protected $login;         // логин пользователя
	protected $fcs;         // ФИО пользователя
	protected $email;         // email пользователя
	protected $passwordHash;  // хэш пароля пользователя

	public function getLogin(): string
	{
		return $this->login;
	}

	public function getFcs(): string
	{
		return $this->fcs;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getPasswordHash(): string
	{
		return $this->passwordHash;
	}

	public function getAuthToken(): string
	{
		return $this->authToken;
	}

	protected static function getTableName(): string
	{
		return 'user';
	}

	public static function findOneByColumn(string $columnName, $value): ?self
	{
	    $db = Db::getInstance();
	    $result = $db->query(
	        'SELECT * FROM `' . static::getTableName() . '` WHERE `' . $columnName . '` = :value LIMIT 1;',
	        [':value' => $value],
	        static::class
	    );
	    if ($result === []) {
	        return null;
	    }
	    return $result[0];
	}

	public static function login(array $loginData): self
	{
	    if (empty($loginData['login'])) {
	        throw new InvalidArgumentException('Не передан логин');
	    }
		
	    $user = User::findOneByColumn('login', $loginData['login']);
	    if ($user === null) {
			throw new InvalidArgumentException('Нет пользователя с таким логином');
	    }

	    if (empty($loginData['password'])) {
	        throw new InvalidArgumentException('Не передан пароль');
	    }
		
	    if (!password_verify($loginData['password'], $user->getPasswordHash())) {
			throw new InvalidArgumentException('Неправильный пароль');
	    }

		$user->refreshAuthToken();
	    $user->save();

		return $user;
	}

	public static function register(array $registerData): self
	{
		if (empty($registerData['login'])) {
	        throw new InvalidArgumentException('Не передан логин');
	    }

		if (!preg_match('/^[a-zA-Z0-9]+$/', $registerData['login'])) {
			throw new InvalidArgumentException('Login может состоять только из символов латинского алфавита и цифр');
		}

		if (static::findOneByColumn('login', $registerData['login']) !== null) {
			throw new InvalidArgumentException('Пользователь с таким login уже существует');
		}

		if (empty($registerData['email'])) {
	        throw new InvalidArgumentException('Не передан e-mail');
	    }

		if (!filter_var($registerData['email'], FILTER_VALIDATE_EMAIL)) {
			throw new InvalidArgumentException('Email некорректен');
		}
	
		if (static::findOneByColumn('email', $registerData['email']) !== null) {
			throw new InvalidArgumentException('Пользователь с таким email уже существует');
		}

		if (empty($registerData['fcs'])) {
	        throw new InvalidArgumentException('Не переданы ФИО');
	    }

		if (mb_strlen($registerData['fcs']) > 255) {
			throw new InvalidArgumentException('ФИО должено быть не более 255 символов');
		}

	    if (empty($registerData['password'])) {
	        throw new InvalidArgumentException('Не передан пароль');
	    }
		
		if (mb_strlen($registerData['password']) < 6) {
			throw new InvalidArgumentException('Пароль должен быть не менее 6 символов');
		}

	    $user = new User();
		$user->login = $registerData['login'];
		$user->email = $registerData['email'];
		$user->fcs = $registerData['fcs'];
		$user->passwordHash = password_hash($registerData['password'], PASSWORD_DEFAULT);
		$user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
	    $user->save();

		return $user;
	}

	

	public static function edit(array $editData, $userId): self
	{
		if (empty($editData['fcs'])) {
	        throw new InvalidArgumentException('Не переданы ФИО');
	    }

		if (mb_strlen($editData['fcs']) > 255) {
			throw new InvalidArgumentException('ФИО должено быть не более 255 символов');
		}

	    if (empty($editData['password'])) {
	        throw new InvalidArgumentException('Не передан пароль');
	    }
		
		if (mb_strlen($editData['password']) < 6) {
			throw new InvalidArgumentException('Пароль должен быть не менее 6 символов');
		}

		$user = self::getById($userId);
		$user->fcs = $editData['fcs'];
		$user->passwordHash = password_hash($editData['password'], PASSWORD_DEFAULT);
	    $user->save();

		return $user;
	}

	private function refreshAuthToken()
	{
		$this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
	}
}