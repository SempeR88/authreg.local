<?php include __DIR__ . '/../header.php'; ?>

<main>
    <div class="container">
        <div class="row">
            <div class="col l12 site-index">

            <h4>Регистрация</h4>

            <?php if (!empty($error)): ?>
                <div class = "error-message"><?= $error ?></div>
            <?php endif; ?>

            <form action="/users/register" method="post">
                <div class="input-field col s6">
                    <label for="login">Логин</label>
                    <input type="text" name="login" value="<?= $_POST['login'] ?? '' ?>">
                </div>
                <div class="input-field col s6">
                    <label for="fcs">ФИО</label>
                    <input type="text" name="fcs" value="<?= $_POST['fcs'] ?? '' ?>">
                </div>
                <div class="input-field col s6">
                    <label for="email">E-mail</label>
                    <input type="text" name="email" value="<?= $_POST['email'] ?? '' ?>">
                </div>
                <div class="input-field col s6">
                    <label for="password">Пароль</label>
                    <input type="password" name="password" value="<?= $_POST['password'] ?? '' ?>">
                </div>
                <div class="input-field col s12">
                    <input class="waves-effect waves-light btn blue lighten-1" type="submit" value="Зарегистрироваться">
                </div>
            </form>

            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../footer.php'; ?>