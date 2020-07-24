<div class="dashboard__editing">
    <div class="form__container">
        <h2 class="light__title">Modifier le roman</h2>
        <form class="novel__form" method="post">
            <?= $form->input('title', 'Titre du roman.', ['required' => true, 'minlength' => 5]) ?>
            <?= $form->tinyMCE('description', 'Description du roman.', ['required' => true, 'minlength' => 20]) ?>
            <div class="btn btn--novel">
                <button type="submit" class="btn__link">Modifier</button>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#tinyArea'
    });
</script>
