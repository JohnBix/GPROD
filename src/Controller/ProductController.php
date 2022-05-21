<?php

namespace App\Controller;

use App\Model\Stock;
use App\Model\Product;
use App\Controller\StockController;

class ProductController {

    private $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    
    /**
     * Verify a product if exists filter by designation
     *
     * @param  string $designation
     * @return int
     */
    private function checkProductByDesignation(string $designation): int
    {
        $stmt = $this->pdo->prepare("SELECT id FROM product WHERE designation = ?");
        $stmt->execute([$designation]);
        $result = $stmt->fetch();
        if (!empty($result)) {
            return 1;
        } else {
            return 0;
        }
    }
        
    /**
     * Verify a product if exists filter by id
     *
     * @param  int $id
     * @return int
     */
    private function checkProductById(int $id): int
    {
        $stmt = $this->pdo->prepare("SELECT * FROM product WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        if (!empty($result)) {
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
     * Add a new Product
     *
     * @param  Product $product
     * @param  Stock $stock
     * @return array
     */
    public function addProduct(Product $product, Stock $stock): array
    {
        $designation = $product->getDesignation();
        $category_id = $product->getCategoryId();
        $check = $this->checkProductByDesignation($designation);
        if ($check !== 1) {
            $stockController = new StockController($this->pdo);
            $id_stock = $stockController->initStock($stock);
            $product->setStockId($id_stock);
            $stmt = $this->pdo->prepare("INSERT INTO product (id, designation, category_id, stock_id) VALUES (NULL, ?, ?, ?)");
            $stmt->execute([$designation, $category_id, $product->getStockId()]);
            return [
                "status" => "success",
                "message" => "Product successfully added"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Product already exists"
            ];
        }
    }
    
    /**
     * Edit designation of a product
     *
     * @param  int $id
     * @param  Product $product
     * @return array
     */
    public function editProduct(int $id ,Product $product): array
    {
        $check = $this->checkProductById($id);
        if ($check === 1) {
            $designation = $product->getDesignation();
            $stmt = $this->pdo->prepare("UPDATE product SET designation = ? WHERE id = ?");
            $stmt->execute([$designation, $id]);
            return [
                "status" => "success",
                "message" => "Product successfully modified"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Product does not found"
            ];
        }
    }
    
    /**
     * Get all products
     *
     * @return array
     */
    public function findAllProducts(): array
    {
        $stmt = $this->pdo->query("SELECT id, designation, (SELECT name FROM category WHERE id = product.category_id) as cat_name, (SELECT quantity FROM stock WHERE id = product.stock_id) as quantity FROM product");
        $result = $stmt->fetchAll();
        if (!empty($result)) {
            return [
                "products" => $result
            ];
        } else {
            return [
                "products" => NULL
            ];
        }
    }
    
    /**
     * Search a product by ID
     *
     * @param  int $id
     * @return array
     */
    public function findProductById(int $id): array
    {
        $stmt = $this->pdo->prepare("SELECT id, designation, (SELECT name FROM category WHERE id = product.category_id) as cat_name, (SELECT quantity FROM stock WHERE id = product.stock_id) as quantity FROM product WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        if (!empty($result)) {
            return [
                "product" => $result
            ];
        } else {
            return [
                "product" => NULL
            ];
        }
    }
    
    /**
     * Search a product filter by designation
     *
     * @param  string $designation
     * @return array
     */
    public function findProductByDesignation(string $designation): array
    {
        $stmt = $this->pdo->prepare("SELECT id, designation, (SELECT name FROM category WHERE id = product.category_id) as cat_name, (SELECT quantity FROM stock WHERE id = product.stock_id) as quantity FROM product WHERE designation = ?");
        $stmt->execute([$designation]);
        $result = $stmt->fetch();
        if (!empty($result)) {
            return [
                "product" => $result
            ];
        } else {
            return [
                "product" => NULL
            ];
        }
    }
    
    /**
     * Search product filter by category
     *
     * @param  string $category_name
     * @return array
     */
    public function findProductByCategory(string $category_name): array
    {
        $stmt = $this->pdo->prepare("SELECT id, designation, (SELECT name FROM category WHERE id = product.category_id) as cat_name, (SELECT quantity FROM stock WHERE id = product.stock_id) as quantity FROM product WHERE category_id = (SELECT id FROM category WHERE name = ?)");
        $stmt->execute([$category_name]);
        $result = $stmt->fetch();
        if (!empty($result)) {
            return [
                "product" => $result
            ];
        } else {
            return [
                "product" => NULL
            ];
        }   
    }
        
    /**
     * Get an ID of product stock
     *
     * @param  int $id
     * @return int
     */
    private function findProductStockId(int $id): int
    {
        $stmt = $this->pdo->prepare("SELECT stock_id FROM product WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        if (!empty($result)) {
            return $result["stock_id"];
        } else {
            return 0;
        }
    }

    /**
     * Delete a product
     *
     * @param  int $id ID of a product
     * @return array
     */
    public function removeProduct(int $id): array
    {
        $check = $this->checkProductById($id);
        if ($check === 1) {
            $stock_id = $this->findProductStockId($id);
            // Start a transaction to delete product and stock
            try {
                $this->pdo->beginTransaction();
                $stmt = $this->pdo->prepare("DELETE FROM product WHERE id = ?");
                $stmt->execute([$id]);
                $stockController = new StockController($this->pdo);
                $res = $stockController->deleteStock($stock_id);
                $this->pdo->commit();
                return [
                    "status" => "success",
                    "message" => "Product successfully deleted"
                ];
            } catch (\Exception $e) {
                $this->pdo->rollBack();
                return [
                    "status" => "error",
                    "message" => "Something was wrong. Please try again!"
                ];
            }
            // End Transaction
        } else {
            return [
                "status" => "error",
                "message" => "ID does not exists"
            ];
        }
    }
}