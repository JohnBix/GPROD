<?php

namespace App\Controller;

use App\Model\Category;

class CategoryController {

    private $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    
    /**
     * Verify a category if exists filter by name
     *
     * @param  string $name
     * @return int
     */
    private function checkCategoryByName($name): int
    {
        $stmt = $this->pdo->prepare("SELECT id FROM category WHERE name = ?");
        $stmt->execute([$name]);
        $result = $stmt->fetch();
        if (!empty($result)) {
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
     * Verify a category if exists filter by id
     *
     * @param  int $id
     * @return int
     */
    private function checkCategoryById($id): int
    {
        $stmt = $this->pdo->prepare("SELECT * FROM category WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        if (!empty($result)) {
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
     * Methods for adding a category
     *
     * @param  Category $category
     * @return array
     */
    public function addCategory(Category $category): array
    {
        $name = $category->getName();
        $check = $this->checkCategoryByName($name);
        if ($check !== 1) {
            $stmt = $this->pdo->prepare("INSERT INTO category (id, name) VALUES (NULL, ?)");
            $stmt->execute([$name]);
            return [
                "status" => "success",
                "message" => "Category successfully added"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Category already exists"
            ];
        }
    }
    
    /**
     * Methods for editing a category
     *
     * @param  int $id
     * @param  Category $category
     * @return array
     */
    public function editCategory(int $id, Category $category): array
    {
        $check = $this->checkCategoryById($id);
        if ($check === 1) {
            $name = $category->getName();
            $verify = $this->checkCategoryByName($name);
            if ($verify === 1) {
                return [
                    "status" => "error",
                    "message" => "Name already exists"
                ];
            } else {
                $stmt = $this->pdo->prepare("UPDATE category SET name = ? WHERE id = ?");
                $stmt->execute([$name, $id]);
                return [
                    "status" => "success",
                    "message" => "Category successfully modified"
                ];                
            }
        } else {
            return [
                "status" => "error",
                "message" => "Category does not found"
            ];
        }
    }
    
    /**
     * Get all categories
     *
     * @return array
     */
    public function findAllCategories(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM category");
        $result = $stmt->fetchAll();
        if (!empty($result)) {
            return [
                "categories" => $result
            ];
        } else {
            return [
                "categories" => NULL
            ];
        }
    }
    
    /**
     * Search a category filter by id
     *
     * @param  int $id
     * @return array
     */
    public function findCategoryById($id): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM category WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        if (!empty($result)) {
            return [
                "category" => $result
            ];
        } else {
            return [
                "category" => NULL
            ];
        }
    }
    
    /**
     * Search a category filter by name
     *
     * @param  string $name
     * @return array
     */
    public function findCategoryByName($name): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM category WHERE name = ?");
        $stmt->execute([$name]);
        $result = $stmt->fetch();
        if (!empty($result)) {
            return [
                "category" => $result
            ];
        } else {
            return [
                "category" => NULL
            ];
        }
    }
    
    /**
     * Delete a category
     *
     * @param  int $id
     * @return array
     */
    public function removeCategory($id): array
    {
        $check = $this->checkCategoryById($id);
        if ($check === 1) {
            $stmt = $this->pdo->prepare("DELETE FROM category WHERE id = ?");
            $stmt->execute([$id]);
            return [
                "status" => "success",
                "message" => "Category successfully deleted"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "ID does not exists"
            ];
        }
    }
}