<div class="dashboard__editing">
    <div class="form__container">
        <h2 class="light__title">Ajouter un chapitre</h2>
        <form class="novel__form" method="post" action="<?= $router->generateUrl('admin.chapter.new', ['slug' => $novel->getSlug()]) ?>">
            <?php require('_form.php') ?>
            <div class="btn btn--novel">
                <button type="submit" class="btn__link">Créer</button>
            </div>
        </form>
    </div>
</div>
