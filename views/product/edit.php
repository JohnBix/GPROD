<?php

use App\Controller\ProductController;
use App\Model\Product;
use App\Utilities\Connexion;

$id = (int) $params['id'];
$pdo = Connexion::getPDO();
$pc = new ProductController($pdo);
$product = $pc->findProductById($id)["product"];

if (!empty($_POST)) {
    extract($_POST);
    $designation = trim($designation);
    $new_prod = new Product();
    $new_prod->setDesignation($designation);
    $result = $pc->editProduct($id, $new_prod);
}

if (is_null($product)):
?>
<h2>Oops! Invalid URL</h2>
<p>No informations for this ID (here <?= $id ?>).</p>
<?php else: ?>
<a href="<?= $this->router->generate("product_quantity", ['id' => $id]) ?>" class="btn-flat blue-grey lighten-5">Edit product's quantity</a>
<h2>Details of product #<?= $id ?></h2>
<p>All informations concern the product.</p>
<div class="row">
    <div class="col s12 m6 l6">
        <div class="row">
            <div class="col s6 m2 l2">
                <p class="right-align"><strong>ID: </strong></p>
                <p class="right-align"><strong>Designation: </strong></p>
                <p class="right-align"><strong>Quantity: </strong></p>
                <p class="right-align"><strong>Category: </strong></p>
            </div>
            <div class="col s6 m4 l4">
                <p class="my-4"><?= $id ?></p>
                <p class="my-4"><?= $product['designation'] ?></p>
                <p class="my-4"><?= $product['quantity'] ?></p>
                <p class="my-4"><?= $product['cat_name'] ?></p>
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
                <input disabled id="id" type="text" class="validate" value="<?= $product['id'] ?>">
                <label for="id">ID :</label>
            </div>
            <div class="input-field col s12 m6 l12">
                <input id="designation" name="designation" type="text" class="validate" value="<?= $product['designation'] ?>">
                <label for="designation">Designation :</label>
            </div>
            <div class="input-field col s12 m6 l12">
                <input disabled id="quantity" type="number" class="validate" value="<?= $product['quantity'] ?>">
                <label for="quantity">Quantity :</label>
            </div>
            <div class="input-field col s12 m12 l12">
                <input type="submit" class="btn" value="VALIDATE">
            </div>  
        </form>
    </div>
</div>
<?php endif; ?>