<?php

namespace App\Controller;

use App\Model\Stock;

class StockController {

    private $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    
    /**
     * Verify if quantity of a stock is NULL
     *
     * @param  int $id
     * @return int
     */
    private function checkStockIfNull(int $id): int
    {
        $stmt = $this->pdo->prepare("SELECT * FROM stock WHERE quantity = 0  AND id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        if (!empty($result)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Get the quantity value filter by stock ID
     *
     * @param  int $id ID of product stock
     * @return int
     */
    private function getStockQuantity(int $id): int
    {
        $stmt = $this->pdo->prepare("SELECT quantity FROM stock WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch()["quantity"];
    }

    /**
     * Initilize the stock of a product
     *
     * @param  Stock $stock
     * @return int
     */
    public function initStock(Stock $stock): int
    {
        $quantity = $stock->getQuantity();
        $stmt = $this->pdo->prepare("INSERT INTO stock (id, quantity) VALUES (NULL, ?)");
        $stmt->execute([$quantity]);
        return $this->pdo->lastInsertId();
    }
    
    /**
     * Increment a product stock
     *
     * @param  int $id ID of product stock
     * @param  Stock $stock
     * @return array
     */
    public function incStock(int $id, Stock $stock): array
    {
        $prod_quantity = $this->getStockQuantity($id);
        $new_quantity = $prod_quantity + $stock->getQuantity();
        $stmt = $this->pdo->prepare("UPDATE stock SET quantity = ? WHERE id = ?");
        $stmt->execute([$new_quantity, $id]);
        return [
            "status" => "success",
            "message" => "Stock successfully incremented"
        ];
    }
    
    /**
     * Decrement a product stock
     *
     * @param  int $id ID of product stock
     * @param  Stock $stock
     * @return array
     */
    public function decStock(int $id, Stock $stock): array
    {
        $check = $this->checkStockIfNull($id);
        if ($check !== 1) {
            $prod_quantity = $this->getStockQuantity($id);
            $new_quantity = $prod_quantity - $stock->getQuantity();
            if ($new_quantity >= 0) {
                $stmt = $this->pdo->prepare("UPDATE stock SET quantity = ? WHERE id = ?");
                $stmt->execute([$new_quantity, $id]);
                return [
                    "status" => "success",
                    "message" => "Stock successfully decremented"
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => "Cannot reduce stock to $new_quantity"
                ];
            }
        } else {
            return [
                "status" => "error",
                "message" => "Can no longer reduce the stock. It's already at 0"
            ];
        }
    }
    
    /**
     * Delete a product stock
     *
     * @param  int $id ID of a product stock
     * @return int
     */
    public function deleteStock(int $id): int
    {
        $stmt = $this->pdo->prepare("DELETE FROM stock WHERE id = ?");
        $stmt->execute([$id]);
        return 1;
    }
}