<?php

require "../vendor/autoload.php";

$renderer = new \Framework\Rendering\Renderer("../templates/base.php");
$renderer->render("../templates/novel/index.php");
