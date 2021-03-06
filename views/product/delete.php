<?php

use App\Controller\ProductController;
use App\Utilities\Connexion;

session_start();

if (!empty($_SESSION) && array_key_exists("email", $_SESSION)):
    $id = (int) $params['id'];
    $pdo = Connexion::getPDO();
    $pc = new ProductController($pdo);
    $result = $pc->removeProduct($id);
    
    header("Location:". $this->router->generate("all_products"));
else:
    header("Location: ". $this->router->generate("login"));
endif;