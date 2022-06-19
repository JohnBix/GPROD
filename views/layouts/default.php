<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'GPROD' ?></title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" integrity="sha512-UJfAaOlIRtdR+0P6C3KUoTDAxVTuy3lnSXLyLKlHYJlcSU8Juge/mjeaxDNMlw9LgeIotgz5FP8eUQPhX1q10A==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/materialize.min.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/apps.css"/>
</head>
<body class="d-flex flex-column h-100">
    <div class="nav-fixed">
        <nav class="nav-wrapper blue-grey lighten-4">
            <a href="<?= $this->router->generate("all_products") ?>" class="brand-logo">GPROD</a>
            <ul class="right hide-on-med-and-down">
                <li><a href="javascript:void(0)">Profil</a></li>
                <li><a href="javascript:void(0)">Users</a></li>
                <li><a href="<?= $this->router->generate("all_categories") ?>">Categories</a></li>
                <li><a href="javascript:void(0)">Log out</a></li>
            </ul>
        </nav>
    </div> 

    <div class="container mt-4">
        <?= $content ?>
    </div>
    <footer class="footer-copyright">
        <div class="container text-muted">
            Copyright &copy; <?= date('Y') ?> &nbsp;&nbsp; - &nbsp;&nbsp; By John Bix
        </div>
    </footer>
</body>
<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js" integrity="sha512-NiWqa2rceHnN3Z5j6mSAvbwwg3tiwVNxiAQaaSMSXnRRDh5C2mk/+sKQRw8qjV1vN4nf8iK2a0b048PnHbyx+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<script src="<?= BASE_URL ?>assets/js/jquery-2.1.1.min.js"></script>
<script src="<?= BASE_URL ?>assets/js/materialize.js"></script>
<script src="<?= BASE_URL ?>assets/js/apps.js"></script>
</html>