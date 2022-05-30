<?php

use App\Controller\CategoryController;
use App\Model\Category;
use App\Utilities\Connexion;

$pdo = Connexion::getPDO();
$cc = new CategoryController($pdo);

if (!empty($_POST)) {
    extract($_POST);
    $name = trim($name);
    $new = new Category();
    $new->setName($name);
    $result = $cc->addCategory($new);
}

?>
<div class="add">
    <h2>Add a new category</h2>
    <p>Please, fill this form.</p>
    <?php if ($result['status'] === "success"): ?>
        <div class="card-panel green lighten-4" role="alert">
            <?= $result['message']; ?>
        </div>
    <?php elseif ($result['status'] === "error"): ?>
        <div class="card-panel deep-orange lighten-4" role="alert">
            <?= $result['message'] ?>
        </div>
    <?php endif; ?>
    <form method="post" role="form">
        <div class="input-field col s12 m6 l12">
            <input id="name" name="name" type="text" class="validate">
            <label for="name">Name :</label>
        </div>
        <div class="input-field col s12 m6 l12">
            <input type="submit" class="btn" value="VALIDATE">
        </div>
    </form>
</div>