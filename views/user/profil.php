<?php

use App\Controller\UserController;
use App\Model\User;
use App\Utilities\Connexion;

session_start();
if (!empty($_SESSION) && array_key_exists("email", $_SESSION)):

    $email = $_SESSION["email"];
    $pdo = Connexion::getPDO();
    $uc = new UserController($pdo);
    $user = $uc->findUserByEmail($email)["user"];

    if (!empty($_POST)) {
        extract($_POST);
        $pseudo = trim($pseudo);
        $password = trim($password);
        $new = new User();
        $new->setPseudo($pseudo)
            ->setPassword($password)
            ;
        $result = $uc->editUser($user["id"], $new);
    }

    if (is_null($user)):
?>
<h2>Oops! Invalid URL</h2>
<p>No informations for this path.</p>
<?php else: ?>
<h2>Details of this user</h2>
<p>All informations concern the user.</p>
<div class="row">
    <div class="col s12 m6 l6">
        <div class="row">
            <div class="col s6 m2 l2">
                <p class="right-align"><strong>ID: </strong></p>
                <p class="right-align"><strong>Email: </strong></p>
                <p class="right-align"><strong>Pseudo: </strong></p>
                <p class="right-align"><strong>Password: </strong></p>
                <p class="right-align"><strong>Role: </strong></p>
            </div>
            <div class="col s6 m4 l4">
                <p class="my-4"><?= $user["id"] ?></p>
                <p class="my-4"><?= base64_decode($user["email"]) ?></p>
                <p class="my-4"><?= base64_decode($user["pseudo"]) ?></p>
                <p class="my-4"><?= base64_decode($user["pwd"]) ?></p>
                <p class="my-4"><?= base64_decode($user["role"]) ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col s6 m4 l4">
                <a href="javascript:void(0)" id="linkEdit" class="btn btn-outline-success w-100 center-align">EDIT</a>
            </div>
        </div>
    </div>
    <div class="col s12 m6 l6">
        <?php if ($result['status'] === "success"): ?>
            <div class="card-panel green lighten-4" role="alert">
                <?= $result['message']; ?>
            </div>
        <?php elseif ($result['status'] === "error"): ?>
            <div class="card-panel deep-orange lighten-4" role="alert">
                <?= $result['message'] ?>
            </div>
        <?php endif; ?>
        <form method="post" role="form" id="formEdit">
            <div class="input-field col s12 m6 l12">
                <input disabled id="id" type="text" class="validate" value="<?= $user['id'] ?>">
                <label for="id">ID :</label>
            </div>
            <div class="input-field col s12 m6 l12">
                <input disabled id="email" type="email" class="validate" value="<?= base64_decode($user["email"]) ?>">
                <label for="email">Email :</label>
            </div>
            <div class="input-field col s12 m6 l12">
                <input required id="pseudo" name="pseudo" type="text" class="validate" value="<?= base64_decode($user["pseudo"]) ?>">
                <label for="pseudo">Pseudo :</label>
            </div>
            <div class="input-field col s12 m6 l12">
                <input required id="password" name="password" type="password" class="validate" value="<?= base64_decode($user["pwd"]) ?>">
                <label for="password">Password :</label>
            </div>
            <div class="input-field col s12 m12 l12">
                <input type="submit" class="btn" value="VALIDATE">
            </div>  
        </form>
    </div>
</div>
<?php endif;
else:
    header("Location: ". $this->router->generate("login"));
endif; ?>