<div class="dashboard">
    <table>
        <thead>
        <tr>
            <th>Auteur</th>
            <th>Signalement</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($comments as $comment): ?>
            <tr>
                <td><?= $comment->getAuthor() ?></td>
                <td><?= $comment->getReported() ?></td>
                <td class="dashboard__actions-comment">
                    <a href="#" class="dashboard__actions" title="Vérifier">
                        <svg class="dashboard__icon">
                            <use xlink:href="/assets/images/sprite.svg#gear"></use>
                        </svg>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
