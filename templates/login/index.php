<div class="login">
    <div class="form__container">
        <h2 class="light__title">Se connecter à votre compte</h2>
        <form class="login__form" method="post">
            <?php if (!empty($error)):?>
                <div class="invalid-field"><?= $error['credentials'] ?></div>
            <?php endif; ?>
            <input type="text" name="username" placeholder="Identifiant" required class="login__form__input">
            <input type="password" name="password" placeholder="Mot de passe" required class="login__form__input">
            <div class="btn">
                <button type="submit" class="btn__link">Se connecter</button>
            </div>
        </form>
    </div>
</div>
