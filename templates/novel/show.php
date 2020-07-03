<?php

use Framework\Session\FlashMessage;
use Framework\Session\Session;

?>
<div class="wrapper">
    <div class="book__reading">
        <h1 class="book__presentation-title"><?= $chapter->getTitle() ?></h1>
        <?= $chapter->getContent() ?>
    </div>

    <form class="comment__form" method="post" action="<?= $router->generateUrl('comment.new', ['novelSlug' => $novelSlug, 'chapterSlug' => $chapter->getSlug()])?>">
        <?php if (FlashMessage::get('success')): ?>
            <p><?= FlashMessage::get('success') ?></p>
        <?php endif; ?>

        <?php if (FlashMessage::get('errors')): ?>
            <?php $field = ''; ?>
            <?php foreach (FlashMessage::get('errors') as $key => $error): ?>
                <?php if ($field !== $key): ?>
                    <?php $field = $key; ?>
                    <p>Votre <?= $field ?> doit :</p>
                <?php endif; ?>
                <ul>
                    <li>- <?= $error ?></li>
                </ul>
            <?php endforeach; ?>
        <?php endif; ?>
        <input name="pseudo"
               type="text"
               placeholder="Votre pseudo"
               required
               maxlength="15"
               class="login__form__input"
               value="<?php !empty(Session::get('pseudo')) ? print Session::get('pseudo') : ""; ?>">
        <textarea name="commentaire" placeholder="Ajouter un commentaire." class="comment__form__input" required
                  minlength="10"><?php !empty(Session::get('commentaire')) ? print Session::get('commentaire') : ""; ?></textarea>
        <div class="btn">
            <button type="submit" class="btn__link">Commenter</button>
        </div>
    </form>
    <div class="comment__container">
        <?php foreach ($chapter->getComments() as $comment): ?>
            <div class="comment">
                <div class="comment__content">
                    <?= $comment->getContent() ?>
                </div>
                <div class="comment__footer">
                    <div class="comment__author"><?= $comment->getAuthor() ?> le <span
                                class="comment__date"><?= $comment->getCreatedAt()->format('d F Y') ?></span></div>
                    <form method="post" action="<?= $router->generateUrl('comment.report', [
                        'novelSlug'     => $novelSlug,
                        'chapterSlug'   => $chapterSlug,
                        'id'            => $comment->getId()]) ?>">
                        <button type="submit">
                            <svg>
                                <use xlink:href="/assets/images/sprite.svg#danger"></use>
                            </svg>
                        </button>
                    </form>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
Session::delete('errors');
Session::delete('success');
Session::delete('pseudo');
Session::delete('commentaire');
?>
