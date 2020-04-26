<?php

require "../vendor/autoload.php";

$renderer = new \Framework\Rendering\Renderer("../templates/admin/base.php");
$renderer->render("../templates/admin/novel/show.php");
