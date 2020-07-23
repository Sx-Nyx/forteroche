<div class="wrapper">
    <div class="book__reading">
        <h1 class="book__presentation-title"><?= $chapter->getTitle() ?></h1>
        <?= $chapter->getContent() ?>
    </div>

    <form class="comment__form" method="post">
        <?= $form->input('author', 'Votre pseudo.', ['required' => true, 'minlength' => 3, 'maxlength' => 15]) ?>
        <?= $form->textarea('content', 'Ajouter un commentaire.', ['required' => true, 'minlength' => 10]) ?>
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
