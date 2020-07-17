<?php
use Framework\Session\FlashMessage;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700|Open+Sans:500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/main.css">
    <title><?= isset($title) ? $title : 'Administration | Jean-Forteroche' ?></title>
</head>
<body>
<header class="header">
    <a href="/admin" class="header__logo">Jean-Forteroche.</a>
    <nav class="header__nav header__nav-admin">
        <a href="<?= $router->generateUrl('admin.novel') ?>">Le roman</a>
        <a href="<?= $router->generateUrl('admin.comment') ?>">Les commentaires <span class="header__notification">3</span></a>
    </nav>
</header>

<p><?= FlashMessage::get('success') ?></p>

<?= $content ?>

</body>
</html>
