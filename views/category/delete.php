<?php

use App\Controller\CategoryController;
use App\Utilities\Connexion;

$id = (int) $params['id'];
$pdo = Connexion::getPDO();
$cc = new CategoryController($pdo);
$result = $cc->removeCategory($id);

header("Location:". $this->router->generate("all_categories"));