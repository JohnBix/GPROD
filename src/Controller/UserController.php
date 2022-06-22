<?php

namespace App\Controller;

use App\Model\User;

class UserController {

    private $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

        
    /**
     * Verify an User if exists filter by email
     *
     * @param  string $email
     * @return int
     */
    private function checkUserByEmail($email): int
    {
        $stmt = $this->pdo->prepare("SELECT id FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        if (!empty($result)) {
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
     * Verify an User if exists filter by pseudo
     *
     * @param  string $pseudo
     * @return int
     */
    private function checkUserByPseudo($pseudo): int
    {
        $stmt = $this->pdo->prepare("SELECT id FROM user WHERE pseudo = ?");
        $stmt->execute([$pseudo]);
        $result = $stmt->fetch();
        if (!empty($result)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Verify an User if exists filter by ID
     *
     * @param  int $id
     * @return int
     */
    private function checkUserById($id): int
    {
        $stmt = $this->pdo->prepare("SELECT id FROM user WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        if (!empty($result)) {
            return 1;
        } else {
            return 0;
        }
    }
        
    /**
     * Check if User is SuperAdmin
     *
     * @param  int $id
     * @return int
     */
    public function checkIfSuperAdmin($id): int
    {
        $stmt = $this->pdo->prepare("SELECT role FROM user WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        if ($result["role"] === base64_encode("superadmin")) {
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
     * Verify if User exists
     *
     * @param  User $user
     * @return array|NULL
     */
    public function checkLogin(User $user): ?array
    {
        $pseudo = base64_encode($user->getPseudo());
        $password = base64_encode($user->getPassword());
        
        $stmt = $this->pdo->prepare("SELECT email, role FROM user WHERE pwd = ? AND pseudo = ?");
        $stmt->execute([$password, $pseudo]);
        $result = $stmt->fetch();
        if (!empty($result)) {
            return $result;
        } else {
            return NULL;
        }
    }

    /**
     * Method for adding an user
     *
     * @param  User $user
     * @return array
     */
    public function addUser(User $user): array
    {
        $email = base64_encode($user->getEmail());
        $verify = $this->checkUserByEmail($email);
        if ($verify != 1) {
            $pseudo = base64_encode($user->getPseudo());
            $check = $this->checkUserByPseudo($pseudo);
            if ($check != 1) {
                $password = base64_encode($user->getPassword());
                $role = base64_encode($user->getRole());
                $stmt = $this->pdo->prepare("INSERT INTO user (id, email, pseudo, pwd, role) VALUES (NULL, ?, ?, ?, ?)");
                $stmt->execute([$email, $pseudo, $password, $role]);
                return [
                    "status" => "success",
                    "message" => "User successfully registred"
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => "Pseudo aldready exists"
                ];
            }
        } else {
            return [
                "status" => "error",
                "message" => "Email already exists"
            ];
        }
    }
    
    /**
     * Methods for editing an User
     *
     * @param  int $id
     * @param  User $user
     * @return array
     */
    public function editUser($id, User $user): array
    {
        $check = $this->checkUserById($id);
        if ($check === 1) {
            $pseudo = base64_encode($user->getPseudo());
            $verify = $this->checkUserByPseudo($pseudo);
            if ($verify === 1) {
                return [
                    "status" => "error",
                    "message" => "Pseudo already exists"
                ];
            } else {
                $password = base64_encode($user->getPassword());
                $stmt = $this->pdo->prepare("UPDATE user SET pseudo = ?, pwd = ? WHERE id = ?");
                $stmt->execute([$pseudo, $password, $id]);
                return [
                    "status" => "success",
                    "message" => "User successfully modified"
                ];
            }
        } else {
            return [
                "status" => "error",
                "message" => "User does not found"
            ];
        }
    }
    
    /**
     * Get all Users
     *
     * @return array
     */
    public function findAllUsers(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM user");
        $result = $stmt->fetchAll();
        if (!empty($result)) {
            return [
                "users" => $result
            ];
        } else {
            return [
                "users" => NULL
            ];
        }
    }
    
    /**
     * Search an User filter by ID
     *
     * @param  int $id
     * @return array|NULL
     */
    public function findUserById($id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        if (!empty($result)) {
            return [
                "user" => $result
            ];
        } else {
            return [
                "user" => NULL
            ];
        }
    }
        
    /**
     * Search an User filter by email
     *
     * @param  string $email
     * @return array|NULL
     */
    public function findUserByEmail($email): ?array
    {
        $email = base64_encode($email);
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        if (!empty($result)) {
            return [
                "user" => $result
            ];
        } else {
            return [
                "user" => NULL
            ];
        }
    }


    /**
     * Delete an User
     *
     * @param  int $id
     * @return array
     */
    public function removeUser($id): array
    {
        $check = $this->checkUserById($id);
        if ($check === 1) {
            $stmt = $this->pdo->prepare("DELETE FROM user WHERE id = ?");
            $stmt->execute([$id]);
            return [
                "status" => "success",
                "message" => "User successfully deleted"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "ID does not exists"
            ];
        }
    }
}