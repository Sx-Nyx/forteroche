<div class="dashboard__editing">
    <div class="form__container">
        <h2 class="light__title">Modifier un chapitre</h2>
        <form class="novel__form" method="post"">
            <?php require('_form.php') ?>
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
