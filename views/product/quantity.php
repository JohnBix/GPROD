<?php

use App\Controller\ProductController;
use App\Controller\StockController;
use App\Model\Stock;
use App\Utilities\Connexion;

$id = (int) $params['id'];
$pdo = Connexion::getPDO();
$pc = new ProductController($pdo);
$sc = new StockController($pdo);
$product = $pc->findProductById($id)["product"];
$stock_id = $pc->findProductStockId($id);

if (!empty($_POST)) {
    extract($_POST);
    $stock = new Stock();
    if (array_key_exists("incr", $_POST)) {
        $incr = (int) trim($incr);
        $stock->setQuantity($incr);
        $result = $sc->incStock($stock_id, $stock);
    } else {
        $decr = (int) trim($decr);
        $stock->setQuantity($decr);
        $result = $sc->decStock($stock_id, $stock);
    }
}

if (is_null($product)):
?>
<h2>Oops! Invalid URL</h2>
<p>No informations for this ID (here <?= $id ?>).</p>
<?php else: ?>
<div class="quantity">
    <h2>The quantity of the product # <?= $id ?></h2>
    <p>Details of the product's quantity.</p>
    <?php if ($result['status'] === "success"): ?>
        <div class="card-panel green lighten-4" role="alert">
            <?= $result['message']; ?>
        </div>
    <?php elseif ($result['status'] === "error"): ?>
        <div class="card-panel deep-orange lighten-4" role="alert">
            <?= $result['message'] ?>
        </div>
    <?php endif; ?>
    <form role="form">
        <div class="input-field col s12 m6 l12">
            <input disabled id="quant" type="number" class="validate" value="<?= $product['quantity'] ?>">
            <label for="quant">Quantity (Kg or Litres):</label>
        </div>
    </form>
    <ul class="tabs tabs-fixed-width">
        <li class="tab col s6 m6 l6"><a class="active" href="#test-swipe-1">Raise</a></li>
        <li class="tab col s6 m6 l6"><a href="#test-swipe-3">Reduce</a></li>
    </ul>
    <div id="test-swipe-1" class="col s12 m6 l12">
        <form role="form" method="post" action="">    
            <div class="input-field col s12 m6 l12">
                <input id="quantIncr" name="incr" type="number">
                <label for="quantIncr">Increase the stock :</label>
            </div>
            <div class="input-field col s12 m12 l12">
                <input type="submit" class="btn" value="INCREASE">
            </div> 
        </form>
    </div>
    <div id="test-swipe-3" class="col s12">
        <form role="form" method="post" action="">    
            <div class="input-field col s12 m6 l12">
                <input id="quantDecr" name="decr" type="number">
                <label for="quantDecr">Reduce the stock :</label>
            </div>
            <div class="input-field col s12 m12 l12">
                <input type="submit" class="btn" value="REDUCE">
            </div> 
        </form>
    </div>
</div>
<?php endif; ?>