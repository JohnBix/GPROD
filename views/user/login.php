<?php

use App\Controller\UserController;
use App\Model\User;
use App\Utilities\Connexion;

$pdo = Connexion::getPDO();
$uc = new UserController($pdo);

if (!empty($_POST)) {
    extract($_POST);
    $pseudo = trim($pseudo);
    $password = trim($password);
    
    $user = new User();
    $user->setPseudo($pseudo)
        ->setPassword($password)
        ;
    $result = $uc->checkLogin($user);
}

?>
<div class="add">
    <h2>Sign In</h2>
    <?php if (isset($result)): 
        if (is_null($result)): ?>
            <div class="card-panel deep-orange lighten-4" role="alert">
                Identifiant invalid
            </div>
        <?php else:
            session_start();
            $_SESSION["email"] = base64_decode($result["email"]);
            $_SESSION["grole"] = $result["role"];
        ?>
        <script>
            setTimeout(function (){
                document.location = "<?= $this->router->generate("all_products") ?>";
            }, 1000);
        </script>
    <?php endif;endif; ?>
    <form method="post" action="" role="form">
        <div class="input-field col s12 m6 l12">
            <input required id="pseudo" name="pseudo" type="text" class="validate">
            <label for="pseudo">Pseudo :</label>
        </div>
        <div class="input-field col s12 m6 l12">
            <input required id="password" name="password" type="password" class="validate">
            <label for="password">Password :</label>
        </div>
        <div class="input-field col s12 m6 l12">
            <input type="submit" class="btn" value="SIGN IN">
        </div>
    </form>
    <p>Don't have an account yet ? <a href="<?= $this->router->generate("register") ?>"><em>sign up</em></a> here</p>
</div>