<div class="dashboard novel">
    <div class="actions">
        <div class="btn">
            <a href="<?= $router->generateUrl('admin.novel.show', ['slug' => $novel->getSlug(), 'id' => $novel->getId()]) ?>"
               class="btn__link">Modifier
                le roman</a>
        </div>
        <div class="btn">
            <a href="<?= $router->generateUrl('admin.chapter.new', ['slug' => $novel->getSlug()]) ?>" class="btn__link">Ajouter
                un chapitre</a>
        </div>
    </div>
    <table>
        <thead>
        <tr>
            <th>Titre</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($chapters as $chapter): ?>
            <tr>
                <td><?= $chapter->getTitle() ?></td>
                <td <?= $chapter->getStatus() ? 'class="active"' : '' ?>><?= $chapter->getStatus() ? 'En ligne' : 'En attente' ?></td>
                <td>
                    <a href="<?= $router->generateUrl('admin.chapter.edit', ['slug' => $novel->getSlug(), 'id' => $chapter->getId()]) ?>"
                       class="dashboard__actions" title="Editer">
                        <svg class="dashboard__icon">
                            <use xlink:href="assets/images/sprite.svg#edit"></use>
                        </svg>
                    </a>
                    <form action="<?= $router->generateUrl('admin.chapter.delete', ['id' => $chapter->getId()]) ?>" method="POST" onsubmit="return confirm('Voulez vous vraiment supprimer ce chapitre ?')" style="display:inline">
                        <button type="submit" class="dashboard__actions" title="Supprimer">
                            <svg class="dashboard__icon dashboard__icon-red">
                                <use xlink:href="assets/images/sprite.svg#delete"></use>
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
