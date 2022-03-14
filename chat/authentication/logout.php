<?php
    /* effettua il logout e setto false il cookie di autenticazione */
    setcookie("authenticate", "false", time() + 60 * 30, "/");
    setcookie("Id", "", time() + 60 * 30, "/");
    header ("Location: ../chat/index.php?scelta=formLogin");
?>