<?= $form->input('title', 'Titre du chapitre.', ['required' => true, 'minlength' => 5]) ?>
<?= $form->tinyMCE('content', 'Contenu du chapitre.') ?>
<?= $form->checkbox('status', 'Status :') ?>



