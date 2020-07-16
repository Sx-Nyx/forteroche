<?php
use Framework\Session\Session;
?>
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
<input name="titre" type="text" placeholder="Titre du chapitre" class="login__form__input" value="<?= !empty(Session::get('title')) ? Session::get('title') : $chapter->getTitle() ?>">
<textarea name="contenu" placeholder="Contenu du chapitre" class="login__form__input"><?= !empty(Session::get('content')) ? Session::get('content') : $chapter->getContent() ?></textarea>
<div class="toggle__label"><label for="scales" class="toggle__statut">Statut :</label>
    <input type="checkbox" id="scales" name="online" class="toggle__box" <?= !empty(Session::get('status')) || $chapter->getStatus() === 1 ? 'checked' : '' ?>>
    <label for="scales" class="toggle"></label>
</div>


