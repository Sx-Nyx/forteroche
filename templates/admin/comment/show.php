<div class="wrapper">
    <h2 class="light__title">Vérification du commentaire</h2>
    <div class="comment">
        <div class="comment__content">
            <?= $comment->getContent() ?>
        </div>
        <div class="comment__footer">
            <div class="comment__author">
                <?= $comment->getAuthor() ?> le
                <span class="comment__date"><?= $comment->getCreatedAt()->format('d F Y') ?></span>
                Signalé <?= $comment->getReported() ?> fois
            </div>
        </div>
    </div>
    <form action="<?= $router->generateUrl('admin.comment.edit', ['id' => $comment->getId()]) ?>" method="POST" style="display:inline">
        <button type="submit" class="dashboard__actions" title="Approuver">
            Approuver
        </button>
    </form>
    <form action="<?= $router->generateUrl('admin.comment.delete', ['id' => $comment->getId()]) ?>" method="POST" onsubmit="return confirm('Voulez vous vraiment supprimer ce commentaire ?')" style="display:inline">
        <button type="submit" class="dashboard__actions" title="Supprimer">
            Supprimer
        </button>
    </form>
</div>
