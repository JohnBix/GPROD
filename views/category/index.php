<?php

use App\Controller\CategoryController;
use App\Utilities\Connexion;

session_start();

if (!empty($_SESSION) && array_key_exists("email", $_SESSION)):

    $pdo = Connexion::getPDO();
    $cc = new CategoryController($pdo);
    $all = $cc->findAllCategories()["categories"];

?>
<a href="<?= $this->router->generate("category_add") ?>" class="btn-flat blue-grey lighten-5">New category...</a>
<h2 class="pt-4">All categories</h2>
<p>List of all available categories.</p>
<div class="input-field inline">
    <input type="text" id="qTable" class="validate">
    <label for="qTable">Search</label>
</div>
<div class="responsive-table">
    <table id="catTable" class="centered highlight">
        <thead>
            <th>#</th>
            <th>NAME</th>
            <th>ACTIONS</th>
        </thead>
        <tbody>
            <?php if ($all === NULL): ?>
                <tr><td colspan="3">No items found.</td></tr>
            <?php else: ?>
                <?php foreach ($all as $one): ?>
                    <tr>
                        <th scope="row"><?=$one['id'] ?></th>
                        <td><?=$one['name'] ?></td>
                        <td>
                            <a href="<?= $this->router->generate("category_show", ['id' => $one['id']]) ?>" data-bs-toggle="tooltip" title="Edit" class="btn btn-floating green lighten-3"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg></a>
                            <form method="POST" action="<?= $this->router->generate("category_delete", ['id' => $one['id']]) ?>" style="display: inline;">
                                <button data-toggle="tooltip" title="Delete" class="btn btn-floating deep-orange lighten-3" onclick="return confirm('Do you really want to perform this action ?')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16"><path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/></svg></button>
                            </form>
                        </td>
                    </tr>
            <?php endforeach;endif; ?>
        </tbody>
    </table>
</div>
<?php else:
    header("Location: ". $this->router->generate("login"));
endif; ?>