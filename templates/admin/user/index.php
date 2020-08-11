<div class="form__container">
    <h2 class="light__title">Modifier votre mot de passe</h2>
    <form method="post" class="login__form" action="<?= $router->generateUrl('user.index') ?>">
        <?php if (!empty($error['password'])): ?>
            <div class="invalid-field"><?= $error['password'] ?></div>
        <?php endif; ?>
        <input name="password" type="password" placeholder="Mot de passe actuel." class="login__form__input" required>
        <?php if (!empty($error['password_confirm'])): ?>
            <div class="invalid-field"><?= $error['password_confirm'] ?></div>
        <?php endif; ?>
        <input name="new_password" type="password" placeholder="Nouveau mot de passe." class="login__form__input" required minlength="5">
        <input name="new_password_confirm" type="password" placeholder="Confirmation du nouveau mot de passe." class="login__form__input" required minlength="5">
        <button type="submit" class="btn__link">Modifier</button>
    </form>
</div>
