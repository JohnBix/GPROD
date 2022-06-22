<?php

use App\Utilities\Router;

require_once '../vendor/autoload.php';

define('VIEW_PATH', dirname(__DIR__). '/views');
define('BASE_URL', dirname($_SERVER['SCRIPT_NAME']));

$router = new Router(VIEW_PATH);
$router 
        // Product
        ->get('/', 'product/index', 'all_products')
        ->match('/product/new', 'product/add', 'product_add')
        ->match('/product/[i:id]', 'product/edit', 'product_show')
        ->match('/product/[i:id]/edit/quantity', 'product/quantity', 'product_quantity')
        ->post('/product/[i:id]/delete', 'product/delete', 'product_delete')
        // Category
        ->get('/category', 'category/index', 'all_categories')
        ->match('/category/new', 'category/add', 'category_add')
        ->match('/category/[i:id]', 'category/edit', 'category_show')
        ->post('/category/[i:id]/delete', 'category/delete', 'category_delete')
        // User
        ->match('/register', 'user/register', 'register')
        ->match('/login', 'user/login', 'login')
        ->get('/logout', 'user/logout', 'logout')
        ->get('/users', 'user/list', 'all_users')
        ->post('/users/[i:id]/delete', 'user/delete', 'user_delete')
        ->match('/profil', 'user/profil', 'profil')
        ->run()
    ;