<?php
use Framework\Session\Session;
?>
<div class="dashboard__editing">
    <div class="form__container">
        <h2 class="light__title">Modifier le roman</h2>
        <form class="novel__form" method="post" action="<?= $router->generateUrl('admin.novel.edit', ['slug' => $novel->getSlug(), 'id' => $novel->getId()]) ?>">
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
            <input name="titre" type="text" placeholder="Nom du roman" required class="login__form__input" value="<?= !empty(Session::get('title')) ? Session::get('title') : $novel->getTitle() ?>">
            <textarea name="description" placeholder="Description du roman" required class="login__form__input"><?= !empty(Session::get('description')) ? Session::get('description') : $novel->getDescription() ?></textarea>
            <div class="btn btn--novel">
                <button type="submit" class="btn__link">Modifier</button>
            </div>
        </form>
    </div>
</div>
