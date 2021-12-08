    <?php include __DIR__ . '/../header.php'; ?>

<main>
    <div class="container">
        <div class="row">
            <div class="col l12 site-index">

            <h4>Пользователь</h4>

            <?php if(!empty($error)): ?>
                <div class = "error-message"><?= $error ?></div>
            <?php endif; ?>

            <table border="0" cellspacing="0" cellpadding="0" style="width:100%; margin-bottom: 30px;">
                <tbody>
                    <tr>
                        <td width="20%">Имя:</td>
                        <td width="80%"><?= $user->getLogin() ?></td>
                    </tr>
                    <tr>
                        <td width="20%">ФИО:</td>
                        <td width="80%"><?= $user->getFcs() ?></td>
                    </tr>
                    <tr>
                        <td width="20%">Email:</td>
                        <td width="80%"><?= $user->getEmail() ?></td>
                    </tr>
                </tbody>
            </table>

            <div><a class="waves-effect waves-light btn blue lighten-1" href="/users/<?= $user->getId() ?>/edit"><i class="material-icons left">edit</i>Редактировать</a></div>

            </div>
        </div>
    </div>
</main>


<?php include __DIR__ . '/../footer.php'; ?>