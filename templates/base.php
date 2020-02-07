<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700|Open+Sans:500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
    <title><?= isset($title) ? $title : 'Jean-Forteroche' ?></title>
</head>
<body>
<header class="header">
    <a href="/" class="header__logo">Jean-Forteroche.</a>
    <nav class="header__nav">
        <a href="#">Accueil</a>
        <a href="#">Le roman</a>
    </nav>
</header>
<?= $content ?>
</body>
</html>
