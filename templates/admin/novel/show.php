<div class="dashboard__editing">
    <div class="form__container">
        <h2 class="light__title">Modifier le roman</h2>
        <form class="novel__form" method="post">
            <?= $form->input('title', 'Titre du roman.', ['required' => true, 'minlength' => 5]) ?>
            <?= $form->textarea('description', 'Description du roman.', ['required' => true, 'minlength' => 20]) ?>
            <div class="btn btn--novel">
                <button type="submit" class="btn__link">Modifier</button>
            </div>
        </form>
    </div>
</div>
