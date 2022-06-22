<?php

use App\Controller\UserController;
use App\Model\User;
use App\Utilities\Connexion;

$pdo = Connexion::getPDO();
$uc = new UserController($pdo);

if (!empty($_POST)) {
    extract($_POST);
    $email = trim($email);
    $pseudo = trim($pseudo);
    $password = trim($password);
    $role = trim($role);
    
    $user = new User();
    $user ->setEmail($email)
        ->setPseudo($pseudo)
        ->setPassword($password)
        ->setRole($role)
        ;
    $result = $uc->addUser($user);
}

?>

<div class="add">
    <h2>Registration</h2>
    <p>Please, fill this form.</p>
    <?php if (isset($result)):
        if ($result['status'] === "success"): ?>
        <div class="card-panel green lighten-4" role="alert">
            <?= $result['message']; ?>
        </div>
        <script>
            setTimeout(function (){
                document.location = "<?= $this->router->generate("login") ?>";
            }, 2000);
        </script>
    <?php elseif ($result['status'] === "error"): ?>
        <div class="card-panel deep-orange lighten-4" role="alert">
            <?= $result['message'] ?>
        </div>
    <?php endif;endif; ?>
    <form method="post" action="" role="form">
        <div class="input-field col s12 m6 l12">
            <input required id="email" name="email" type="email" class="validate">
            <label for="email">Email :</label>
        </div>
        <div class="input-field col s12 m6 l12">
            <input required id="pseudo" name="pseudo" type="text" class="validate">
            <label for="pseudo">Pseudo :</label>
        </div>
        <div class="input-field col s12 m6 l12">
            <input required id="password" name="password" type="password" class="validate">
            <label for="password">Password :</label>
        </div>
        <div class="input-field col s12 m6 l12">
            <select name="role" required>
                <option value="" disabled selected>Choose a role</option>
                <option value="superadmin">Super Admin</option>    
                <option value="admin">Admin</option>    
                <label>Role :</label>
            </select>
        </div>
        <div class="input-field col s12 m6 l12">
            <input type="submit" class="btn" value="VALIDATE">
        </div>
    </form>
</div>