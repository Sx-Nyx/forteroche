<?php
use Framework\Session\Session;
?>

<div class="dashboard__editing">
    <div class="form__container">
        <h2 class="light__title">Ajouter un chapitre</h2>
        <form class="novel__form" method="post" action="<?= $router->generateUrl('admin.chapter.new', ['slug' => $novel->getSlug()]) ?>">
            <?php if (!empty($errors)): ?>
                <?php $field = ''; ?>
                <?php foreach ($errors as $key => $error): ?>
                    <?php if ($field !== $key): ?>
                        <?php $field = $key; ?>
                        <p>Le champ <?= $field ?> :</p>
                    <?php endif; ?>
                    <ul>
                        <li>- <?= $error ?></li>
                    </ul>
                <?php endforeach; ?>
            <?php endif; ?>
            <input name="titre" type="text" placeholder="Titre du chapitre"  class="login__form__input" value="<?= !empty(Session::get('title')) ? Session::get('title') : '' ?>">
            <textarea name="contenu" placeholder="Contenu du chapitre"  class="login__form__input"><?= !empty(Session::get('content')) ? Session::get('content') : '' ?></textarea>
            <div class="toggle__label">
                <label for="scales" class="toggle__statut">Statut :</label>
                <input type="checkbox" id="scales" name="online" class="toggle__box" <?= !empty(Session::get('status')) ? 'checked' : '' ?>>
                <label for="scales" class="toggle"></label>
            </div>
            <div class="btn btn--novel">
                <button type="submit" class="btn__link">Créer</button>
            </div>
        </form>
    </div>
</div>
