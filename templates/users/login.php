<?php include __DIR__ . '/../header.php'; ?>

<main>
    <div class="container">
        <div class="row">
            <div class="col l12 site-index">

            <h4>Авторизация</h4>

            <?php if (!empty($error)): ?>
                <div class = "error-message"><?= $error ?></div>
            <?php endif; ?>

            <form action="/users/login" method="post">
                <div class="input-field col s6">
                    <label for="login">Логин</label>
                    <input type="text" name="login" value="<?= $_POST['login'] ?? '' ?>">
                </div>
                <div class="input-field col s6">
                    <label>Пароль</label>
                    <input type="password" name="password" value="<?= $_POST['password'] ?? '' ?>">
                </div>
                <div class="input-field col s12">
                    <input class="waves-effect waves-light btn blue lighten-1" type="submit" value="Войти">
                </div>
            </form>

            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../footer.php'; ?>