<div class="wrapper">
    <div class="book__reading">
        <h1 class="book__presentation-title"><?= $chapter->getTitle() ?></h1>
        <?= $chapter->getContent() ?>
    </div>
    <form class="comment__form">
        <textarea placeholder="Ajouter un commentaire." class="comment__form__input" required minlength="10"></textarea>
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
                    <form action="#">
                        <svg>
                            <use xlink:href="assets/images/sprite.svg#danger"></use>
                        </svg>
                    </form>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</div>
