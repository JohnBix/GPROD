<?php

use App\Controller\UserController;
use App\Utilities\Connexion;

session_start();

if (!empty($_SESSION) && array_key_exists("email", $_SESSION)):

    $id = (int) $params['id'];
    $pdo = Connexion::getPDO();
    $uc = new UserController($pdo);
    $result = $uc->removeUser($id);

    header("Location:". $this->router->generate("all_users"));
else:
    header("Location: ". $this->router->generate("login"));
endif;