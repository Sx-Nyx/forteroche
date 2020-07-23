<?= $form->input('title', 'Titre du chapitre.', ['required' => true, 'minlength' => 5]) ?>
<?= $form->textarea('content', 'Contenu du chapitre.', ['required' => true, 'minlength' => 20]) ?>
<?= $form->checkbox('status', 'Status :') ?>



