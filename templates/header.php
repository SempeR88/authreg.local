<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/images/favicon.png" type="image/png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/materialize.min.css"  media="screen,projection"/>
	<title><?= $title ?? 'Авторизация Регистрация' ?></title>
</head>
<body>

<header>
    <div class="container">
        <div class="row">
            <div class="col l8 title">
                <h1 class="center-align"><?= $title ?? 'Авторизация Регистрация' ?></h1>
            </div>
            <div class="col l4 panel">
                <?php if (!empty($user)) { ?> 
                    <div>Привет, <strong><a href="/users/<?= $user->getId() ?>/view"><?= $user->getFcs() ?></a></strong> | <a class="waves-effect waves-light btn blue lighten-1" href="/users/logout"><i class="material-icons left">exit_to_app</i>Выйти</a></div>
                <?php } else { ?>
                    <div>
                        <a class="waves-effect waves-light btn blue lighten-1" href="/users/login"><i class="material-icons left">person</i>Войти</a>
                        <a class="waves-effect waves-light btn blue lighten-1" href="/users/register"><i class="material-icons left">person</i>Регистрация</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</header>