<?php

use App\Controller\ProductController;
use App\Utilities\Connexion;

$id = (int) $params['id'];
$pdo = Connexion::getPDO();
$pc = new ProductController($pdo);
$result = $pc->removeProduct($id);

header("Location:". $this->router->generate("all_products"));