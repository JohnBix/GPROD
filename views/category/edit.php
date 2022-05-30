<?php

use App\Controller\CategoryController;
use App\Model\Category;
use App\Utilities\Connexion;

$id = (int) $params['id'];
$pdo = Connexion::getPDO();
$cc = new CategoryController($pdo);
$category = $cc->findCategoryById($id)['category'];

if (!empty($_POST)) {
    extract($_POST);
    $name = trim($name);
    $new = new Category();
    $new->setName($name);
    $result = $cc->editCategory($id, $new);
}

if (is_null($category)):
?>
<h2>Oops! Invalid URL</h2>
<p>No informations for this ID (here <?= $id ?>).</p>
<?php else: ?>
<h2>Details of category #<?= $id ?></h2>
<p>All informations concern the category.</p>
<div class="row">
    <div class="col s12 m6 l6">
        <div class="row">
            <div class="col s6 m2 l2">
                <p class="right-align"><strong>ID: </strong></p>
                <p class="right-align"><strong>Name: </strong></p>
            </div>
            <div class="col s6 m4 l4">
                <p class="my-4"><?= $id ?></p>
                <p class="my-4"><?= $category['name'] ?></p>
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
                <input disabled id="id" type="text" class="validate" value="<?= $category['id'] ?>">
                <label for="id">ID :</label>
            </div>
            <div class="input-field col s12 m6 l12">
                <input id="name" name="name" type="text" class="validate" value="<?= $category['name'] ?>">
                <label for="name">Name :</label>
            </div>
            <div class="input-field col s12 m12 l12">
                <input type="submit" class="btn" value="VALIDATE">
            </div>  
        </form>
    </div>
</div>
<?php endif; ?>