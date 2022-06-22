<?php

session_start();

if (!empty($_SESSION)):

    unset($_SESSION["email"]);
    session_destroy();
    ?>
    <p><em>Deconnexion in progress ...</em></p>
    <script>
        setTimeout(function (){
            document.location = "<?= $this->router->generate("login") ?>";
        }, 500);
    </script>
<?php else:
    header("Location: ". $this->router->generate("login"));
endif; ?>