<div class="wrapper reading">
    <div class="book__presentation book__presentation--center">
        <h1 class="book__presentation-title"><?= $novel->getTitle() ?></h1>
        <p class="book__presentation-description"><?= $novel->getDescription() ?></p>
    </div>
    <div class="chapter__list">
    <?php foreach($chapters as $chapter): ?>
        <a class="chapter__card" href="#">
            <h1 class="chapter__title light__title"><?= $chapter->getTitle() ?></h1>
            <p class="chapter__excerpt"><?= $chapter->getContent() ?></p>
            <span class="chapter__comment">Commentaires: <?= $chapter->getNumberComment() ?></span>
        </a>
    <?php endforeach ?>
    </div>
</div>
