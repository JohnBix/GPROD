<?php

use App\Controller\CategoryController;
use App\Utilities\Connexion;

session_start();

if (!empty($_SESSION) && array_key_exists("email", $_SESSION)):

    $id = (int) $params['id'];
    $pdo = Connexion::getPDO();
    $cc = new CategoryController($pdo);
    $result = $cc->removeCategory($id);

    header("Location:". $this->router->generate("all_categories"));
else:
    header("Location: ". $this->router->generate("login"));
endif;