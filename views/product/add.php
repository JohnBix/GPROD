<?php

use App\Controller\CategoryController;
use App\Controller\ProductController;
use App\Model\Product;
use App\Model\Stock;
use App\Utilities\Connexion;

session_start();

if (!empty($_SESSION) && array_key_exists("email", $_SESSION)):

    $pdo = Connexion::getPDO();
    $cc = new CategoryController($pdo);
    $pc = new ProductController($pdo);
    $categories = $cc->findAllCategories()["categories"];

    if (!empty($_POST)) {
        extract($_POST);
        $designation = trim($designation);
        $quantity = (int) trim($quantity);
        $category_id = (int) trim($category_id);
        
        $new_stock = new Stock();
        $new_stock->setQuantity($quantity);
        $new_product = new Product();
        $new_product->setDesignation($designation)
                    ->setCategoryId($category_id)
                ;
        $result = $pc->addProduct($new_product, $new_stock);
    }

?>
<div class="add">
    <h2>Add a new product</h2>
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
            <input id="designation" name="designation" type="text" class="validate">
            <label for="designation">Designation :</label>
        </div>
        <div class="input-field col s12 m6 l12">
            <input id="quantity" name="quantity" type="number" class="validate">
            <label for="quantity">Quantity (en Kilogrammes ou Litres):</label>
        </div>
        <div class="input-field col s12 m6 l12">
            <select name="category_id" required>
                <option value="" disabled selected>Choose a category</option>
            <?php foreach ($categories as $one): ?>
                <option value="<?= $one["id"] ?>"><?= $one["name"] ?></option>
            <?php endforeach; ?>    
                <label>Category :</label>
            </select>
        </div>
        <div class="input-field col s12 m6 l12">
            <input type="submit" class="btn" value="VALIDATE">
        </div>
    </form>
</div>
<?php else:
    header("Location: ". $this->router->generate("login"));
endif; ?>