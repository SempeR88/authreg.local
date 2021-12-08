<?php include __DIR__ . '/../header.php'; ?>

<main>
    <div class="container">
        <div class="row">
            <div class="col l12 site-index">

            <h4>Редактирование пользователя</h4>

            <?php if(!empty($error)): ?>
                <div class = "error-message"><?= $error ?></div>
            <?php endif; ?>

            <form action="/users/<?= $user->getId() ?>/edit" method="post">
                <div class="input-field col s6">
                    <label for="fcs">ФИО</label>
                    <input type="text" name="fcs" id="fcs" value="<?= $_POST['fcs'] ?? $user->getFcs() ?>" size="50">
                </div>
                <div class="input-field col s6">
                    <label for="password">Пароль</label>
                    <input type="text" name="password" id="password" value="<?= $_POST['password'] ?? '' ?>" size="50">
                </div>
                <div class="input-field col s9">
                    <input class="waves-effect waves-light btn blue lighten-1" type="submit" value="Обновить">
                </div>
            </form>

            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../footer.php'; ?>